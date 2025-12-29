import mysql.connector
from mysql.connector import Error
import pandas as pd
import numpy as np
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
from flask import Flask, jsonify


app = Flask(__name__)

conn = mysql.connector.connect(
    host="127.0.0.1",
    user="root",
    password="",
    database="doantotnghiep",
    port=3306,
)

df_products = pd.read_sql("SELECT * FROM products", conn)
df_evaluates = pd.read_sql("SELECT * FROM reviews", conn)
conn.close()

user_product_matrix = df_evaluates.pivot_table(
    index="IdUser", columns="IdProduct_Review", values="Evaluate", fill_value=0
)

item_mean = user_product_matrix.replace(0, np.nan).mean(axis=0)
item_centered = user_product_matrix.copy()
for product in item_centered.columns:
    mean = item_mean[product]
    item_centered.loc[:, product] = item_centered.loc[:, product].apply(
        lambda x: x - mean if x > 0 else 0
    )
item_user_matrix = item_centered.T
item_similarity = cosine_similarity(item_user_matrix.fillna(0))

item_similarity_df = pd.DataFrame(
    item_similarity,
    index=item_user_matrix.index,
    columns=item_user_matrix.index,
)


def get_similar_items(item_id, top_k=5):
    if item_id not in item_similarity_df.index:
        return pd.Series(dtype=float)

    sims = item_similarity_df[item_id].drop(item_id)
    sims = sims[sims > 0]
    return sims.sort_values(ascending=False).head(top_k)


def predict_rating_iicf(user_id, item_id, top_k=5):
    if user_id not in user_product_matrix.index:
        return None
    if item_id not in user_product_matrix.columns:
        return None

    similar_items = get_similar_items(item_id, top_k)

    numerator = 0
    denominator = 0

    for sim_item_id, similarity in similar_items.items():
        rating = user_product_matrix.at[user_id, sim_item_id]

        if rating > 0:
            numerator += similarity * (rating - item_mean[sim_item_id])
            denominator += abs(similarity)

    if denominator == 0:
        return item_mean[item_id]

    return item_mean[item_id] + numerator / denominator


def recommend_item_item(user_id, top_n=10):
    if user_id not in user_product_matrix.index:
        return []

    recommendations = []

    for item_id in user_product_matrix.columns:
        if user_product_matrix.loc[user_id, item_id] == 0:
            pred = predict_rating_iicf(user_id, item_id)
            if pred is not None:
                recommendations.append((item_id, pred))

    recommendations.sort(key=lambda x: x[1], reverse=True)
    return recommendations[:top_n]


@app.route("/recommend-item/<int:user_id>", methods=["GET"])
def recommend_item_api(user_id):
    recs = recommend_item_item(user_id)

    results = []
    for item_id, score in recs:
        p = df_products[df_products["IdProduct"] == item_id].iloc[0]
        results.append(
            {
                "IdProduct": item_id,
                "NameProduct": p["NameProduct"],
                "ImageURL": p["ImageURL"],
                "NewPrice": p["NewPrice"],
                "OldPrice": p["OldPrice"],
                "PredictedRating": round(score, 2),
            }
        )

    return jsonify({"user_id": user_id, "recommendations": results})


user_mean = user_product_matrix.replace(0, pd.NA).mean(axis=1)
user_product_centered = user_product_matrix.copy()
for user in user_product_centered.index:
    mean = user_mean[user]
    user_product_centered.loc[user] = user_product_centered.loc[user].apply(
        lambda x: x - mean if x > 0 else 0
    )
print(user_product_centered)
user_similarity = cosine_similarity(user_product_centered.fillna(0))
user_similarity_df = pd.DataFrame(
    user_similarity,
    index=user_product_centered.index,
    columns=user_product_centered.index,
)


def get_similar_users(user_id, top_n=5):
    if user_id not in user_similarity_df.index:
        return pd.Series(dtype=float)
    sims = user_similarity_df[user_id].drop(user_id)
    sims = sims[sims > 0]
    return sims.sort_values(ascending=False).head(top_n)


def predict_rating(user_id, product_id, top_n=5):
    if user_id not in user_product_matrix.index:
        return None
    if product_id not in user_product_matrix.columns:
        return None
    similar_users = get_similar_users(user_id, top_n)
    numerator = 0
    denominator = 0
    for sim_user_id, similarity in similar_users.items():
        rating = user_product_matrix.at[sim_user_id, product_id]
        if rating > 0:
            numerator += similarity * (rating - user_mean[sim_user_id])
            denominator += abs(similarity)
    if denominator == 0:
        return user_mean[user_id]
    return user_mean[user_id] + numerator / denominator


def recommend_user_user(user_id, top_n=10):
    if user_id not in user_product_matrix.index:
        return []
    recommendations = []
    for product_id in user_product_matrix.columns:
        if user_product_matrix.loc[user_id, product_id] == 0:
            pred = predict_rating(user_id, product_id)
            if pred is not None:
                recommendations.append((product_id, pred))
    recommendations.sort(key=lambda x: x[1], reverse=True)
    return recommendations[:top_n]


@app.route("/recommend-user/<int:user_id>", methods=["GET"])
def recommend_user_api(user_id):
    recs = recommend_user_user(user_id)

    results = []
    for product_id, score in recs:
        p = df_products[df_products["IdProduct"] == product_id].iloc[0]
        results.append(
            {
                "IdProduct": product_id,
                "NameProduct": p["NameProduct"],
                "ImageURL": p["ImageURL"],
                "NewPrice": p["NewPrice"],
                "OldPrice": p["OldPrice"],
                "PredictedRating": round(score, 2),
            }
        )

    return jsonify({"user_id": user_id, "recommendations": results})


def combine_features(row):
    return (
        f"{row['IdProduct']} "
        f"{row['NewPrice']} "
        f"{row['Category']} "
        f"{row['SubCategory']} "
        f"{row['Tag']}"
    )


df_products["combined_features"] = df_products.apply(combine_features, axis=1)

tf = TfidfVectorizer()
tf_matrix = tf.fit_transform(df_products["combined_features"])
cosine_sim = cosine_similarity(tf_matrix)

index_map = pd.Series(df_products.index, index=df_products["IdProduct"])


def recommend_products(product_id, top_n=10):
    if product_id not in index_map:
        return []

    idx = index_map[product_id]
    sim_scores = list(enumerate(cosine_sim[idx]))
    sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)
    sim_scores = sim_scores[1 : top_n + 1]

    results = []
    for i, score in sim_scores:
        p = df_products.iloc[i]
        results.append(
            {
                "IdProduct": p["IdProduct"],
                "NameProduct": p["NameProduct"],
                "ImageURL": p["ImageURL"],
                "NewPrice": p["NewPrice"],
                "OldPrice": p["OldPrice"],
                "Score": round(float(score), 4),
            }
        )

    return results


@app.route("/recommend/<string:product_id>", methods=["GET"])
def recommend_api(product_id):
    data = recommend_products(product_id)
    return jsonify(
        {
            "product_id": product_id,
            "recommendations": data,
        }
    )


if __name__ == "__main__":
    app.run(debug=True)

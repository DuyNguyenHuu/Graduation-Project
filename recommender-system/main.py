import mysql.connector
from mysql.connector import Error
import pandas as pd
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
conn.close()


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

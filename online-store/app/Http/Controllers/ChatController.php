<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index()
    {
        return view('content.chat');
    }

    public function askAI(Request $request)
    {
        try {

            $message = $request->input('message');

            $client = OpenAI::client(env('OPENAI_API_KEY'));

            /*
            ================================
            STEP 1: AI phân tích câu hỏi
            ================================
            */

            $analysis = $client->chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => '
                        Bạn là AI phân tích câu hỏi tìm sản phẩm.

                        Database có các trường:
                        NameProduct, TypeProduct, Tag, Description, Category, SubCategory, NewPrice.

                        Hãy phân tích câu hỏi người dùng và trả về JSON:

                        {
                            "keyword": "",
                            "type": "",
                            "category": "",
                            "price_max": null
                        }

                        Chỉ trả JSON, không giải thích.
                        '
                    ],
                    [
                        'role' => 'user',
                        'content' => $message
                    ]
                ]
            ]);

            $analysisText = $analysis->choices[0]->message->content;

            $data = json_decode($analysisText, true);

            $keyword = $data['keyword'] ?? null;
            $type = $data['type'] ?? null;
            $category = $data['category'] ?? null;
            $priceMax = $data['price_max'] ?? null;

            /*
            ================================
            STEP 2: Query database + join options
            ================================
            */

            $products = DB::table('products')
                ->where('products.StatusProduct', 'Publish')

                ->leftJoin('options', 'products.IdProduct', '=', 'options.IdProduct_Option')

                ->when($keyword, function ($query) use ($keyword) {
                    $query->where(function ($q) use ($keyword) {

                        $q->where('products.NameProduct', 'like', "%$keyword%")
                          ->orWhere('products.Tag', 'like', "%$keyword%")
                          ->orWhere('products.Description', 'like', "%$keyword%");
                    });
                })

                ->when($type, function ($query) use ($type) {
                    $query->where('products.TypeProduct', 'like', "%$type%");
                })

                ->when($category, function ($query) use ($category) {
                    $query->where(function ($q) use ($category) {

                        $q->where('products.Category', 'like', "%$category%")
                          ->orWhere('products.SubCategory', 'like', "%$category%");
                    });
                })

                ->when($priceMax, function ($query) use ($priceMax) {
                    $query->where('products.NewPrice', '<=', $priceMax);
                })

                ->select(
                    'products.IdProduct',
                    'products.NameProduct',
                    'products.TypeProduct',
                    'products.NewPrice',
                    'products.OldPrice',
                    'products.Category',
                    'products.SubCategory',
                    'products.Tag',
                    'products.Description',
                    'options.SubOption'
                )

                ->limit(10)

                ->get();

            /*
            ================================
            STEP 3: Gom size theo sản phẩm
            ================================
            */

            $productData = $products->groupBy('IdProduct')->map(function ($items) {

                $product = $items->first();

                $sizes = $items->pluck('SubOption')
                               ->filter()
                               ->unique()
                               ->values();

                $slug = Str::slug($product->NameProduct);

                return [
                    "name" => $product->NameProduct,
                    "type" => $product->TypeProduct,
                    "price" => $product->NewPrice,
                    "tag" => $product->Tag,
                    // "description" => $product->Description,
                    "category" => $product->Category,
                    "subCategory" => $product->SubCategory,
                    "sizes" => $sizes,
                    "url" => url('/products/' . $slug)
                ];
            })->values();

            /*
            ================================
            STEP 4: AI tạo câu trả lời
            ================================
            */

            $response = $client->chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => '
                        Bạn là AI tư vấn sản phẩm cho website bán hàng.

                        Nếu người dùng hỏi về kích thước:
                        hãy dựa vào trường "sizes".

                        Nếu tìm thấy sản phẩm phù hợp hãy:
                        - giới thiệu sản phẩm
                        - liệt kê kích thước nếu có
                        - mô tả sản phẩm dựa vào trường "description" nếu có
                        - liệt kê tag nếu có
                        - liệt kê category nếu có
                        - đưa link sản phẩm

                        Link sản phẩm nằm trong trường "url".
                        '
                    ],
                    [
                        'role' => 'system',
                        'content' => 'Danh sách sản phẩm: ' . json_encode($productData)
                    ],
                    [
                        'role' => 'user',
                        'content' => $message
                    ]
                ]
            ]);

            $reply = $response->choices[0]->message->content;

            return response()->json([
                'reply' => $reply
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'reply' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }
}
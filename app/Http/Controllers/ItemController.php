<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Items",
 *     description="Operations about Pokemon cards"
 * )
 */

class ItemController extends Controller
{
    private $path = 'app/items.json';

    /**
     * @OA\Get(
     *     path="/api/items",
     *     tags={"Items"},
     *     summary="Get all items",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function index()
    {
        $items = $this->readData();

        foreach ($items as &$item) {
            $item['price_formatted'] = "Rp " . number_format($item['price'], 0, ',', '.');
        }

        return response()->json([
            "status" => "success",
            "data" => $items
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/items/{id}",
     *     tags={"Items"},
     *     summary="Get item by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Item not found"
     *     )
     * )
     */
    public function show($id)
    {
        $items = $this->readData();

        foreach ($items as $item) {
            if ($item['id'] == $id) {
                return response()->json([
                    "status" => "success",
                    "data" => $item
                ]);
            }
        }

        return response()->json([
            "status" => "error",
            "message" => "Kartu dengan ID $id tidak ditemukan"
        ], 404);
    }

    /**
     * @OA\Post(
     *     path="/api/items",
     *     tags={"Items"},
     *     summary="Create a new item",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="rarity", type="string", enum={"S","A","B","C","E"}),
     *             @OA\Property(property="price", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Item created"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'rarity' => 'required|in:S,A,B,C,E',
            'price' => 'required|numeric'
        ]);

        $items = $this->readData();

        $newId = count($items) > 0 ? max(array_column($items, 'id')) + 1 : 1;

        $newItem = [
            'id' => $newId,
            'name' => $request->name,
            'rarity' => $request->rarity,
            'price' => $request->price
        ];

        $items[] = $newItem;

        file_put_contents(storage_path($this->path), json_encode($items, JSON_PRETTY_PRINT));

        return response()->json([
            "status" => "success",
            "data" => $newItem
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/items/{id}",
     *     tags={"Items"},
     *     summary="Update an item",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="rarity", type="string", enum={"S","A","B","C","E"}),
     *             @OA\Property(property="price", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item updated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Item not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'rarity' => 'required|in:S,A,B,C,E',
            'price' => 'required|numeric'
        ]);

        $items = $this->readData();

        foreach ($items as &$item) {
            if ($item['id'] == $id) {
                $item['name'] = $request->name;
                $item['rarity'] = $request->rarity;
                $item['price'] = $request->price;

                file_put_contents(
                    storage_path($this->path),
                    json_encode($items, JSON_PRETTY_PRINT)
                );

                return response()->json([
                    "status" => "success",
                    "data" => $item
                ]);
            }
        }

        return response()->json([
            "status" => "error",
            "message" => "Kartu dengan ID $id tidak ditemukan"
        ], 404);
    }
    /**
     * @OA\Patch(
     *     path="/api/items/{id}",
     *     tags={"Items"},
     *     summary="Partially update an item",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="rarity", type="string", enum={"S","A","B","C","E"}),
     *             @OA\Property(property="price", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item updated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Item not found"
     *     )
     * )
     */
    public function patch(Request $request, $id)
    {
        $items = $this->readData();

        foreach ($items as &$item) {
            if ($item['id'] == $id) {
                if ($request->has('name')) {
                    $item['name'] = $request->name;
                }

                if ($request->has('rarity')) {
                    if (!in_array($request->rarity, ['S','A','B','C','E'])) {
                        return response()->json([
                            "status" => "error",
                            "message" => "Rarity tidak valid"
                        ], 400);
                    }
                    $item['rarity'] = $request->rarity;
                }

                if ($request->has('price')) {
                    $item['price'] = $request->price;
                }

                file_put_contents(
                    storage_path($this->path),
                    json_encode($items, JSON_PRETTY_PRINT)
                );

                return response()->json([
                    "status" => "success",
                    "data" => $item
                ]);
            }
        }

        return response()->json([
            "status" => "error",
            "message" => "Kartu dengan ID $id tidak ditemukan"
        ], 404);
    }

    /**
     * @OA\Delete(
     *     path="/api/items/{id}",
     *     tags={"Items"},
     *     summary="Delete an item",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Item not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $items = $this->readData();

        foreach ($items as $key => $item) {
            if ($item['id'] == $id) {

                unset($items[$key]);

                $items = array_values($items);

                file_put_contents(
                    storage_path($this->path),
                    json_encode($items, JSON_PRETTY_PRINT)
                );

                return response()->json([
                    "status" => "success",
                    "message" => "Kartu berhasil dihapus"
                ]);
            }
        }

        return response()->json([
            "status" => "error",
            "message" => "Kartu dengan ID $id tidak ditemukan"
        ], 404);
    }

    private function readData()
    {
        if (!file_exists(storage_path($this->path))) {
            return [];
        }

        $json = file_get_contents(storage_path($this->path));
        return json_decode($json, true) ?? [];
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\V1\IndexBookRequest;
use App\Http\Resources\Api\V1\BookResource;
use App\Models\Book;

class BookController extends Controller
{
    public function index(IndexBookRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $perPage = $validated['per_page'] ?? 10;

        $books = Book::with(['genres'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->filter($validated)
            ->paginate($perPage);

        return response()->json([
            'data' => BookResource::collection($books),
            'meta' => [
                'current_page' => $books->currentPage(),
                'last_page' => $books->lastPage(),
                'per_page' => $books->perPage(),
                'total' => $books->total(),
            ],
        ], 200);
    }

    public function show(Book $book): JsonResponse
    {
        $book->load(['genres', 'reviews'])
            ->loadAvg('reviews', 'rating')
            ->loadCount('reviews')
            ->get();

        return response()->json([
            'data' => new BookResource($book),
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Interfaces\PostRepositoryInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository) 
    {
        $this->postRepository = $postRepository;
    }

    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */

    /**
     * @OA\Get(
     * path="/api/posts",
     * summary = "Get list post",
     * operationId = "Index",
     * tags={"List Articles"},
     * @OA\Response(response=200, description="successful operation"),
     * @OA\Response(response=406, description="not acceptable"),
     * @OA\Response(response=500, description="internal server error")
     * )
     */
    public function index(Request $request)
    {

        $data = $request->is_published === "true" ? 
            $this->postRepository->getPublishedPosts() :
            $this->postRepository->getAllPost();

        return response()->json([
            "message" => 'success',
            'data' => $data
        ]);
    }

    /**
     * @OA\Post(
     *      path="/api/store",
     *      operationId="store",
     *      tags={"Create Articles"},
     *      summary="Create and store article in DB",
     *      description="Create and store article in DB",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(),
     *         @OA\MediaType(
    *            mediaType="multipart/form-data",
    *            @OA\Schema(
        *               type="object",
        *               required={"title","content", "is_published"},
        *               @OA\Property(property="title", type="text"),
        *               @OA\Property(property="content", type="text"),
        *               @OA\Property(property="is_published", type="integer"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Store Successfully",
        *          @OA\JsonContent()
        *       ),
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=""),
     *             @OA\Property(property="data",type="object")
     *          )
     *       )
     *  )
     */
    public function store(StorePostRequest $request)
    {
        return response()->json(
            [
                "message" => 'success',
                'data' => $this->postRepository->createPost($request)
            ],
        );
    }

    /**
     * @OA\Get(
     *    path="/api/articles/{id}",
     *    operationId="show",
     *    tags={"Get Article Detail"},
     *    summary="Get Article Detail",
     *    description="Get Article Detail",
     *    @OA\Parameter(name="id", in="path", description="Id of Article", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *          @OA\Property(property="id", type="integer", example="25"),
     *          @OA\Property(property="data",type="object")
     *           ),
     *        )
     *       )
     *  )
     */
    public function show(Request $request)
    {
        return response()->json([
            "message" => 'success',
            'data' => $this->postRepository->getPostById($request->route('id'))
        ]);
    }

    /**
     * @OA\Put(
     *      path="/articles/update/{id}",
     *      operationId="update",
     *      tags={"Update Article"},
     *      summary="Update article in DB",
     *      description="Update article in DB",
     *      @OA\Parameter(name="id", in="path", description="Id of Article", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           required={"title", "content", "status"},
     *           @OA\Property(property="title", type="string", format="string", example="Test Article Title"),
     *           @OA\Property(property="content", type="string", format="string", example="This is a description for kodementor"),
     *           @OA\Property(property="status", type="string", format="string", example="Published"),
     *        ),
     *     ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status_code", type="integer", example="200"),
     *             @OA\Property(property="data",type="object")
     *          )
     *       )
     * )
     * 
     */
    public function update(UpdatePostRequest $request)
    {
        return response()->json([
            "message" => 'success',
            'data' => $this->postRepository->updatePost($request->route('id'), $request)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->postRepository->deletePost($request->route('id'));

        return response()->json([
            "message" => 'success',
        ]);
    }
}
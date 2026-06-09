<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Models\BlogPost;
use App\Repositories\BlogPostRepository;
use App\Repositories\BlogCategoryRepository;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Http\Requests\BlogPostCreateRequest;

class PostController extends BaseController
{
    private BlogCategoryRepository $blogCategoryRepository;

    public function __construct(private BlogPostRepository $blogPostRepository)
    {
        //parent::__construct();
        $this->blogCategoryRepository = new BlogCategoryRepository();
    }

    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginate();
        return $paginator;
    }

    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();

        $item = (new BlogPost())->create($data);

        if ($item) {
            return ['success' => true, 'message' => 'Успішно збережено'];
        } else {
            return ['msg' => 'Помилка збереження'];
        }
    }

    public function update(BlogPostUpdateRequest $request, $id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)) {
            return ['message' => "Запис id=[{$id}] не знайдено"];
        }

        $data = $request->input();

        $result = $item->update($data);

        if ($result) {
            return [
                'success' => true,
                'message' => 'Успішно збережено'
            ];
        } else {
            return ['message' => 'Помилка збереження'];
        }
    }

    public function destroy($id)
    {
        $result = BlogPost::destroy($id); //софт делит, запис лишається

        //$result = BlogPost::find($id)->forceDelete(); //повне видалення з БД

        if ($result) {
            return ['success' => true, 'message' => 'Успішно видалено'];
        } else {
            return ['message' => 'Помилка видалення'];
        }
    }
}

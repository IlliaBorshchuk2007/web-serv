<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Http\Requests\BlogCategoryCreateRequest;
use Illuminate\Support\Str;

class CategoryController extends BaseController
{
    public function __construct(private BlogCategoryRepository $blogCategoryRepository)
    {
        //parent::__construct();
    }

    public function index()
    {
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(5);
        return $paginator;
    }

    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $item = BlogCategory::create($data);

        if ($item) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => $item
            ];
        } else {
            return ['message' => 'Помилка збереження'];
        }
    }

    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);
        if (empty($item)) {
            return ['message' => "Запис id=[{$id}] не знайдено"];
        }

        $data = $request->input();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

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
}

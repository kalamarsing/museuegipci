<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Repositories\PageRepository;


use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageField;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;

class PageController extends Controller
{
    public function __construct(PageRepository $pages) {
        $this->pages = $pages;
    }

    public function get($pageId, Request $request)
    {

        return response()->json($this->pages->findById($pageId));
      
    }


    public function getAll(Request $request)
    {

        return response()->json($this->pages->getAll($request->all()));

    }

    public function index(Request $request): View
    {
        return view('backend.page.index',[
            'pages' => $this->pages->getAll($request->all())
        ]);
    }

    public function create(Request $request)
    {
        return  view('backend.page.form');
    }

    public function show($pageId, Request $request)
    {
        $success = true;
        $message = '';
        try{
            $page = $this->pages->findById($pageId);
            

            if($page->type == 'file' ||
            $page->type == 'text' ||
            $page->type == 'richtext' ){
                $fields = $page->fields()->first() ?  $page->fields()->first()->value : null;
            }elseif($page->type == 'MultiLanguageText' ||
            $page->type == 'MultiLanguageRichtext'){
                $fields = $page->getLocalizedFields();
                $fields = isset($fields['field']) ? $fields['field'] : null;

            }else{
                $fields = null;
            }

        } catch (\Exception $e) {
            $message = $e->getMessage();
            $success = false;
        }

        return  view('backend.page.form',[
            'page' => $page,
            'fields' => $fields,
            'success' => $success,
            'message' => $message
        ]);
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'identifier' => ['required', 'string', 'max:255'],
                'type' => ['required', 'string', 'max:255'],
            ]);

            $page = Page::create([
                'identifier' => $request->identifier,
                'type' => $request->type
            ]);
            
            if($request->type == 'file' ||
                $request->type == 'text' ||
                $request->type == 'richtext' ){
                PageField::updateOrCreate(
                    ['page_id' => $page->id, 'language_id' => null, 'name' => 'field'],
                    ['value' => $request->fields]
                );
            }

            if($request->type == 'MultiLanguageText' ||
            $request->type == 'MultiLanguageRichtext'  ){
                foreach ($request->fields as $languageId => $value) {
                    PageField::updateOrCreate(
                        ['page_id' => $page->id, 'language_id' => $languageId, 'name' => 'field'],
                        ['value' => $value]
                    );
                }
            }
            

        } catch (\Exception $e) {
            $message = $e->getMessage();

            return response()->json([
                'success' => false,
                'message' => $message
            ]);

        }

        if($page->type == 'file' ||
            $page->type == 'text' ||
            $page->type == 'richtext' ){
            $fields = $page->fields()->first() ?  $page->fields()->first()->value : null;

        }elseif($page->type == 'MultiLanguageText' ||
        $page->type == 'MultiLanguageRichtext'){
            $fields = $page->getLocalizedFields();

        }else{
            $fields = null;
        }


        return response()->json([
            'page' => $page,
            'fields' => $fields,
            'success' => true
        ]);

    }


    public function update(Request $request, $id)
    {
        try{
            $page = $this->pages->findById($id);

            $page->identifier = $request->identifier;
            $page->type = $request->type;

            $page->save();

            $page->fields()->delete();

            if($request->type == 'file' ||
                $request->type == 'text' ||
                $request->type == 'richtext' ){
                PageField::updateOrCreate(
                    ['page_id' => $page->id, 'language_id' => null, 'name' => 'field'],
                    ['value' => $request->fields]
                );
            }

            if($request->type == 'MultiLanguageText' ||
            $request->type == 'MultiLanguageRichtext'  ){
                foreach ($request->fields as $languageId => $value) {
                    PageField::updateOrCreate(
                        ['page_id' => $page->id, 'language_id' => $languageId, 'name' => 'field'],
                        ['value' => $value]
                    );
                }
            }

        } catch (\Exception $e) {
            $message = $e->getMessage();

            return response()->json([
                'success' => false,
                'message' => $message
            ]);

        }

        return response()->json([
            'page' => $page,
            'success' => true
        ]);
    
    }

    /**
     * Delete the page's account.
     */
    public function delete(Request $request, $id)
    {

        $page = $this->pages->findById($id);

        $page->delete();
        
        return Redirect::to('/admin/pages');

    }


  
}

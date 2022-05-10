<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedocumentsEditorsRequest;
use App\Http\Requests\UpdatedocumentsEditorsRequest;
use App\Repositories\documentsEditorsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\ImagesDocuments;
use App\Models\documentsEditors;
use App\Models\Service;
use App\Models\ServiceAssigneds;
use App\Models\Role;
use DB;
use Flash;
use Response;
use Illuminate\Support\Collection;

class documentsEditorsController extends AppBaseController
{
    /** @var  documentsEditorsRepository */
    private $documentsEditorsRepository;

    public function __construct(documentsEditorsRepository $documentsEditorsRepo)
    {
        $this->documentsEditorsRepository = $documentsEditorsRepo;
    }

    /**
     * Display a listing of the documentsEditors.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        //dd(DB::select('SELECT role_id FROM documents_editors GROUP BY role_id'));
        $documentsEditors = documentsEditors::orderBy('name_document_editor', 'asc')->orderBy('role_id', 'asc')->get();
        $services = Service::all();
        $services2 = Service::all();

        return view('documents_editors.index')
            ->with('documentsEditors', $documentsEditors)
            ->with('services', $services)
            ->with('roles', Role::all());
    }

    /**
     * Show the form for creating a new documentsEditors.
     *
     * @return Response
     */
    public function create()
    {
        $imagesDocuments = ImagesDocuments::all();
        $services = Service::all();
        $roles = Role::all();
        return view('documents_editors.create')->with('imagesDocuments', $imagesDocuments)->with('roles', $roles)->with('services', $services);
    }

    /**
     * Store a newly created documentsEditors in storage.
     *
     * @param CreatedocumentsEditorsRequest $request
     *
     * @return Response
     */
    public function store(CreatedocumentsEditorsRequest $request)
    {
        $input = $request->all();

        $pathfolderStorage = '../resources/views/pdf';

        if (!is_dir($pathfolderStorage)) {
            mkdir($pathfolderStorage, 0777, true);
        }

        $backgroundImg = '';
        if($input['backgroundImg'] != '' && $input['backgroundImg'] != null){
            $backgroundImg = '
                <style type="text/css">
                    @page {
                        margin-top: 1.3in;
                        margin-left: 0.8in;
                        margin-right: 0.8in;
                        margin-bottom: 1in;
                    }
                    body {
                        background-color: rgba(0,0,0,0);
                    }
                    body:before {
                        display: block;
                        position: fixed;
                        top: -1in; right: -1in; bottom: -1in; left: -1in;
                        background-image: url(' . $input['backgroundImg'] . ');
                        background-size: 100% 100%;
                        margin: -20px 15px 15px 10px !important;
                        background-repeat: no-repeat;
                        content: "";
                        z-index: -1000;
                    }
                </style>';
        }

        $initHTML = '
        <!DOCTYPE html>
        <html lang="es">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                ' . $backgroundImg . '
                <title>' . $input['name_document_editor'] . '</title>
            </head>
            <body>
        ';

        $endHTML = '
            </body>
        </html>
        ';

        $contentReplace = '';
        $contentReplace = $input['content'];
        $contentReplace = str_replace('&gt;', '>', $contentReplace);
        $contentReplace = str_replace('&lt;', '<', $contentReplace);
        $contentReplace = str_replace('<p><script type=', '<script type=', $contentReplace);
        $contentReplace = str_replace('</script></p>', '</script>', $contentReplace);
        $pageNumber = '"$PAGE_NUM"';
        $contentReplace = str_replace('<$PAGE_NUM>', $pageNumber, $contentReplace);
        $fonts = '"Arial, Helvetica, sans-serif", "bold"';
        $contentReplace = str_replace('<fonts>', $fonts, $contentReplace);
        $contentReplace = str_replace('../../../../', 'http://app.unitedfamilyhc.com/', $contentReplace);

        $fileCreate = fopen('../resources/views/pdf/' . str_replace(' ', '_', $input['name_document_editor']) . '.blade.php', 'w+b');
        fwrite($fileCreate, $initHTML);
        fwrite($fileCreate, $contentReplace);
        fwrite($fileCreate, $endHTML);
        fflush($fileCreate);
        fclose($fileCreate);

        $documentsEditors = $this->documentsEditorsRepository->create($input);

        Flash::success('Documents Editors saved successfully.');

        return redirect(route('documentsEditors.index'));
    }

    /**
     * Display the specified documentsEditors.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $documentsEditors = $this->documentsEditorsRepository->find($id);
        $services = Service::all();
        $roles = Role::all();

        if (empty($documentsEditors)) {
            Flash::error('Documents Editors not found');

            return redirect(route('documentsEditors.index'));
        }

        return view('documents_editors.show')->with('documentsEditors', $documentsEditors)->with('roles', $roles)->with('services', $services);
    }

    /**
     * Show the form for editing the specified documentsEditors.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $imagesDocuments = ImagesDocuments::all();
        $services = Service::all();
        $roles = Role::all();

        $documentsEditors = $this->documentsEditorsRepository->find($id);

        if (empty($documentsEditors)) {
            Flash::error('Documents Editors not found');

            return redirect(route('documentsEditors.index'));
        }

        return view('documents_editors.edit')->with('documentsEditors', $documentsEditors)->with('imagesDocuments', $imagesDocuments)->with('roles', $roles)->with('services', $services);
    }

    /**
     * Update the specified documentsEditors in storage.
     *
     * @param int $id
     * @param UpdatedocumentsEditorsRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $documentsEditors = $this->documentsEditorsRepository->find($id);

        if (empty($documentsEditors)) {
            Flash::error('Documents Editors not found');

            return redirect(route('documentsEditors.index'));
        }

        unlink('../resources/views/pdf/' . str_replace(' ', '_', $documentsEditors->name_document_editor). '.blade.php'); //elimino el fichero

        $input = $request->all();

        $pathfolderStorage = '../resources/views/pdf';

        if (!is_dir($pathfolderStorage)) {
            mkdir($pathfolderStorage, 0777, true);
        }

        $backgroundImg = '';
        if($input['backgroundImg'] != '' && $input['backgroundImg'] != null){
            $backgroundImg = '
                <style type="text/css">
                    @page {
                        margin-top: 1.3in;
                        margin-left: 0.8in;
                        margin-right: 0.8in;
                        margin-bottom: 1in;
                    }
                    body {
                        background-color: rgba(0,0,0,0);
                    }
                    body:before {
                        display: block;
                        position: fixed;
                        top: -1in; right: -1in; bottom: -1in; left: -1in;
                        background-image: url(' . $input['backgroundImg'] . ');
                        background-size: 100% 100%;
                        background-repeat: no-repeat;
                        margin: -20px 15px 15px 10px !important;
                        content: "";
                        z-index: -1000;
                    }
                </style>';
        }

        $initHTML = '
        <!DOCTYPE html>
        <html lang="es">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                ' . $backgroundImg . '
                <title>' . $input['name_document_editor'] . '</title>
            </head>
            <body>
        ';

        $endHTML = '
            </body>
        </html>
        ';

        $contentReplace = '';
        $contentReplace = $input['content'];
        $contentReplace = str_replace('&gt;', '>', $contentReplace);
        $contentReplace = str_replace('&lt;', '<', $contentReplace);
        $contentReplace = str_replace('<p><script type=', '<script type=', $contentReplace);
        $contentReplace = str_replace('</script></p>', '</script>', $contentReplace);
        $pageNumber = '"$PAGE_NUM"';
        $contentReplace = str_replace('<$PAGE_NUM>', $pageNumber, $contentReplace);
        $fonts = '"Arial, Helvetica, sans-serif", "bold"';
        $contentReplace = str_replace('<fonts>', $fonts, $contentReplace);
        $contentReplace = str_replace('../../../../', 'http://app.unitedfamilyhc.com/', $contentReplace);

        $fileCreate = fopen('../resources/views/pdf/' . str_replace(' ', '_', $input['name_document_editor']) . '.blade.php', 'w+b');
        fwrite($fileCreate, $initHTML);
        fwrite($fileCreate, $contentReplace);
        fwrite($fileCreate, $endHTML);
        fclose($fileCreate);

        $documentsEditors = $this->documentsEditorsRepository->update($input, $id);

        Flash::success('Documents Editors updated successfully.');

        return redirect(route('documentsEditors.index'));
    }

    /**
     * Remove the specified documentsEditors from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $documentsEditors = $this->documentsEditorsRepository->find($id);

        if (empty($documentsEditors)) {
            Flash::error('Documents Editors not found');

            return redirect(route('documentsEditors.index'));
        }

        $pathfolderStorage = '../resources/views/pdf';

        if (!is_dir($pathfolderStorage)) {
            mkdir($pathfolderStorage, 0777, true);
        }

        unlink('../resources/views/pdf/' . str_replace(' ', '_', $documentsEditors->name_document_editor) . '.blade.php'); //elimino el fichero

        $this->documentsEditorsRepository->delete($id);

        Flash::success('Documents Editors deleted successfully.');

        return redirect(route('documentsEditors.index'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function store(Request $request)
    {
        // print_r($request->all());exit;
        // exit;
        // $request->validate([
        //     'image' => 'required|mimetypes:image/jpeg,image/png,image/jpg,image/gif|max:2048',
        // ]);
        $all = $request->all();
        $all['user_id'] = auth()->user()->id;
        $image = $request->file('image');
        $name = $image->getClientOriginalExtension();
        if ($image) {
            $destinationPath = 'images/';
            $imgName = time() . "." . $name;
            $image->move($destinationPath, $imgName);
            $all['name'] = $imgName;
        }
        Image::create($all);
        auth()->user()->last_image_type = $all['type'];
        auth()->user()->save();
        return redirect()->route('gallery')
                        ->with('success','Image Uploaded successfully.');
    }

    public function show()
    {
        $images = auth()->user()->images;
        $portrait = $landscape = $all = array();
        if(count($images)){
            foreach ($images as $img) {
                if($img->type == 1){
                    $portrait[] = $img->name;
                }else{
                    $landscape[] = $img->name;
                }
            }
            $first = auth()->user()->last_image_type;
            if($first == 1){
                $cnt = (count($landscape) > ceil(count($portrait)/2)) ? count($landscape) : ceil(count($portrait)/2);

                for ($i=0; $i < $cnt; $i++) {
                    if(count($portrait) == 1){
                        $all[] = ['name' => $portrait[0],'type' => 1];
                        array_splice($portrait, 0, 1);
                    }elseif(count($portrait) > 1){
                        $all[] = ['name' => $portrait[0],'type' => 1];
                        $all[] = ['name' => $portrait[1],'type' => 1];
                        array_splice($portrait, 0, 2);
                    }

                    if(count($landscape)){
                        $all[] = ['name' => $landscape[0],'type' => 2];
                        array_splice($landscape, 0, 1);
                    }
                }
            }else{
                $cnt = (count($landscape) > ceil(count($portrait)/2)) ? count($landscape) : ceil(count($portrait)/2);

                for ($i=0; $i < $cnt; $i++) {
                    if(count($landscape)){
                        $all[] = ['name' => $landscape[0],'type' => 2];
                        array_splice($landscape, 0, 1);
                    }

                    if(count($portrait) == 1){
                        $all[] = ['name' => $portrait[0],'type' => 1];
                        array_splice($portrait, 0, 1);
                    }elseif(count($portrait) > 1){
                        $all[] = ['name' => $portrait[0],'type' => 1];
                        $all[] = ['name' => $portrait[1],'type' => 1];
                        array_splice($portrait, 0, 2);
                    }
                }
            }
        }
        return view('gallery',compact(['all']));
    }

    public function download($file)
    {
        $filePath = public_path('images/'.$file);
        return response()->download($filePath);
    }

}

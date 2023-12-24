<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class UploadImageController extends Controller
{
    public function create(Request $request)
    {
        $image = $request->image;

        if(!empty($image))
        {
            $ext = $image->getClientOriginalExtension();
            $newName = time().'.'.$ext;

            $model = new Media();
            $model->name = $newName;
            $model->save();

            $image->move(public_path().'/media',$newName);

            //generate thumb
            // $sourcePath = public_path().'/media/'.$newName;
            // $dPath = public_path().'/media/thumb/'.$newName;

            // $image = Image::make($sourcePath);
            // $image->fit(300,250);
            // $image->save($dPath);
            


            return response()->json([
                'status'=>true,
                'image_id'=>$model->id,
                // 'imagePath'=>asset('temp/thumb/'.$newName),
                'message'=>'Image uploaded successfully'
            ]);
            
        }
    }

    // public function update(Request $request)
    // {
    //     $image = $request->image;
    //     $ext = $image->getClientOriginalExtension();
    //     $sPath = $image->getPathName();

    //     $detailModel = new ProductDetail();
    //     $detailModel->product_id = $request->product_id;
    //     $detailModel->image = 'NULL';
    //     $detailModel->save();

    //     $newImageName = $request->product_id. '-' .$detailModel->id. '-' .time(). '.'.$ext;
    //     $detailModel->image = $newImageName;
    //     $detailModel->save();

    //      // Large Image
    //      $dPath = public_path().'/uploads/product/large/'.$newImageName;
    //      $image = Image::make($sPath);
    //      $image->resize(1400,null,function($constraint){
    //          $constraint->aspectRatio();
    //      });
    //      $image->save($dPath);

    //      //generate thumb
    //      $dPath = public_path().'/uploads/product/thumb/'.$newImageName;
    //      $img = Image::make($sPath);
    //      // $img->resize(300, 200);
    //      $img->fit(300, 200, function ($constraint) {
    //          $constraint->upsize();
    //      });
    //      $img->save($dPath); 

    //      return response()->json([
    //         'status'=>true,
    //         'image_id'=>$detailModel->id,
    //         'imagePath'=>asset('uploads/product/thumb/'.$detailModel->image),
    //         'message'=>'Image saved successfully',
    //      ]);

    // }

    // public function delete(Request $request)
    // {
    //     $productImage = ProductDetail::find($request->id);

    //     if(empty($productImage))
    //     {
    //         return response()->json([
    //             'status'=>false,
    //             'message'=>'Image not found.',
    //          ]);
    //     }

    //     File::delete(public_path('uploads/product/large/'.$productImage->image));
    //     File::delete(public_path('uploads/product/thumb/'.$productImage->image));

    //     $productImage->delete();

    //     return response()->json([
    //         'status'=>true,
    //         'message'=>'Image deleted successfully',
    //      ]);
    // }
}

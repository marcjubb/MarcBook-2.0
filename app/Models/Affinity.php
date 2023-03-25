<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Affinity extends Model
{
    public static $model;
    use HasFactory;
    /*public static function getModel()
    {
        if (!isset(self::$model)) {
            try {
                $model_path = Storage::disk('local')->path('sar_model.pkl');
                self::$model = joblib.load(model_path);
            } catch (\Exception $e) {
                throw new ModelNotFoundException();
            }
        }
        return self::$model;
    }*/

  /*  public static function recommend($user_id, $num_recommendations)
    {
        $model = self::getModel();
        item_ids = Product::all()->pluck('id')->toArray();
    user_ids = [$user_id];
    scores, _ = model.predict(user_ids, item_ids);
    sorted_indices = np.argsort(scores)[::-1];
    sorted_scores = scores[sorted_indices][:num_recommendations];
    sorted_item_ids = item_ids[sorted_indices][:num_recommendations];
    return Product::whereIn('id', $sorted_item_ids)->get();
}*/
    public function affinity($user_id)
    {
        return Affinity::where('user_id', $user_id)
            ->where('product_id', $this->id)
            ->value('score');
    }


}

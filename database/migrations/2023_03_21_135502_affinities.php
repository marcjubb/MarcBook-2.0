<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affinities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('score');
            $table->timestamps();
        });
    }


/*    // Assuming you have a Laravel model named Affinity for your table
$affinities = Affinity::all();

// Map the Affinity model data to the SAR format
$interactions = $affinities->map(function ($affinity) {
        return [
            'User ID' => $affinity->user_id,
            'Item ID' => $affinity->product_id,
            'Time' => $affinity->created_at->timestamp,
            'Event Type' => 'purchase', // assuming all affinities are for purchases
            'Event Weight' => $affinity->score,
        ];
    });

// Convert the interactions to a Pandas DataFrame
$data = pd.DataFrame($interactions->toArray());

// Convert the time column to a datetime object
$data['Time'] = pd.to_datetime(data['Time'], unit='s')*/



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affinities');
    }
};

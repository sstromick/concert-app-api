<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use App\Models\MetricValue;

class MetricValuesSeeder extends Seeder
{
public function csvToArray($filename = '', $delimiter = ',')
{
    if (!file_exists($filename) || !is_readable($filename))
        return false;

    $header = null;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== false)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
        {
            if (!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }

    return $data;
}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('metric_values')->delete();

        $file = storage_path('2008.csv');
        $fileArr = $this->csvToArray($file);

        for ($i = 0; $i < count($fileArr); $i ++)
        {
            $event = 0;
            foreach ($fileArr[$i] as $key => $value) {
                if ($key == "Tour/Event")
                    $event = $value;
                if ($key != "Shows" && $key != "Tour/Event") {
                    MetricValue::Create([
                        'metric_id' => $key,
                        'metricable_id' => $event,
                        'metricable_type' => 'Event',
                        'value' => $value,
                    ]);
                }
            }
        }

/*
        $metrics = array(
            array( //atten
                'metric_id' => 2,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 2000,
            ),
            array( //co2 artist
                'metric_id' => 3,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 0,
            ),
            array( //co2 fans
                'metric_id' => 4,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 0,
            ),
            array( //biod
                'metric_id' => 5,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 6,
            ),
            array( //compost
                'metric_id' => 6,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 8,
            ),
            array( //recycle
                'metric_id' => 7,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 8,
            ),
            array( //nal
                'metric_id' => 8,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 560,
            ),
            array( //water gal
                'metric_id' => 9,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 0,
            ),
            array( //bottles elim
                'metric_id' => 10,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 1500,
            ),
            array( //gtoups
                'metric_id' => 12,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 1,
            ),
            array( //v confirmed
                'metric_id' => 13,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 20,
            ),
            array( //v onsite
                'metric_id' => 14,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 16,
            ),
            array( //v hours
                'metric_id' => 15,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 128,
            ),
            array( //onsite fans
                'metric_id' => 16,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 1000,
            ),
            array( //online fans
                'metric_id' => 17,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 0,
            ),
            array( //$ rasied
                'metric_id' => 18,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 5500,
            ),
            array( //$ raised
                'metric_id' => 19,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 0,
            ),
            array( //$ we donate
                'metric_id' => 20,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 383,
            ),
            array( //farms
                'metric_id' => 21,
                'metricable_id' => 465,
                'metricable_type' => 'Event',
                'value' => 0,
            ),

//------------------ Lumineers
            array( //atten
                'metric_id' => 2,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 246000,
            ),
            array( //co2 artist
                'metric_id' => 3,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 7692,
            ),
            array( //co2 fans
                'metric_id' => 4,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 3405,
            ),
            array( //biod
                'metric_id' => 5,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 6,
            ),
            array( //compost
                'metric_id' => 6,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 1600,
            ),
            array( //recycle
                'metric_id' => 7,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 8,
            ),
            array( //nal
                'metric_id' => 8,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 2253,
            ),
            array( //water gal
                'metric_id' => 9,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 1258,
            ),
            array( //bottles elim
                'metric_id' => 10,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 10063,
            ),
            array( //gtoups
                'metric_id' => 12,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 24,
            ),
            array( //v confirmed
                'metric_id' => 13,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 250,
            ),
            array( //v onsite
                'metric_id' => 14,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 168,
            ),
            array( //v hours
                'metric_id' => 15,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 672,
            ),
            array( //onsite fans
                'metric_id' => 16,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 2000,
            ),
            array( //online fans
                'metric_id' => 17,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 596,
            ),
            array( //$ rasied
                'metric_id' => 18,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 260471,
            ),
            array( //$ raised
                'metric_id' => 19,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 14579,
            ),
            array( //$ we donate
                'metric_id' => 20,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 163779,
            ),
            array( //farms
                'metric_id' => 21,
                'metricable_id' => 462,
                'metricable_type' => 'Event',
                'value' => 40,
            ),

//------------------ Sturgill Simpson
            array( //atten
                'metric_id' => 2,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 100000,
            ),
            array( //co2 artist
                'metric_id' => 3,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 7692,
            ),
            array( //co2 fans
                'metric_id' => 4,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 3405,
            ),
            array( //biod
                'metric_id' => 5,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 6,
            ),
            array( //compost
                'metric_id' => 6,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 1600,
            ),
            array( //recycle
                'metric_id' => 7,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 8,
            ),
            array( //nal
                'metric_id' => 8,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 756,
            ),
            array( //water gal
                'metric_id' => 9,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 251,
            ),
            array( //bottles elim
                'metric_id' => 10,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 2008,
            ),
            array( //gtoups
                'metric_id' => 12,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 23,
            ),
            array( //v confirmed
                'metric_id' => 13,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 89,
            ),
            array( //v onsite
                'metric_id' => 14,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 62,
            ),
            array( //v hours
                'metric_id' => 15,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 186,
            ),
            array( //onsite fans
                'metric_id' => 16,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 3904,
            ),
            array( //online fans
                'metric_id' => 17,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 0,
            ),
            array( //$ rasied
                'metric_id' => 18,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 9080,
            ),
            array( //$ raised
                'metric_id' => 19,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 0,
            ),
            array( //$ we donate
                'metric_id' => 20,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 0,
            ),
            array( //farms
                'metric_id' => 21,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 0,
            ),

//------------------ Tame Impala US Q1
            array( //atten
                'metric_id' => 2,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 40000,
            ),
            array( //co2 artist
                'metric_id' => 3,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 0,
            ),
            array( //co2 fans
                'metric_id' => 4,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 0,
            ),
            array( //biod
                'metric_id' => 5,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 0,
            ),
            array( //compost
                'metric_id' => 6,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 1600,
            ),
            array( //recycle
                'metric_id' => 7,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 8,
            ),
            array( //nal
                'metric_id' => 8,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 756,
            ),
            array( //water gal
                'metric_id' => 9,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 251,
            ),
            array( //bottles elim
                'metric_id' => 10,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 2008,
            ),
            array( //gtoups
                'metric_id' => 12,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 23,
            ),
            array( //v confirmed
                'metric_id' => 13,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 89,
            ),
            array( //v onsite
                'metric_id' => 14,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 62,
            ),
            array( //v hours
                'metric_id' => 15,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 186,
            ),
            array( //onsite fans
                'metric_id' => 16,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 3904,
            ),
            array( //online fans
                'metric_id' => 17,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 0,
            ),
            array( //$ rasied
                'metric_id' => 18,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 9080,
            ),
            array( //$ raised
                'metric_id' => 19,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 0,
            ),
            array( //$ we donate
                'metric_id' => 20,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 0,
            ),
            array( //farms
                'metric_id' => 21,
                'metricable_id' => 460,
                'metricable_type' => 'Event',
                'value' => 0,
            ),

        );

        DB::table('metric_values')->insert($metrics);
        */
    }
}

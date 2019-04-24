<?php

 function importcsvToDB($filePath, $model){
    $fileD = fopen($filePath,"r");
        // $column=fgetcsv($fileD);
        while(!feof($fileD)){
         $rowData[]=fgetcsv($fileD);
        }
        foreach ($rowData as $key => $value) {
            
            $inserted_data=array('name'=>$value[0],
                            );
             $model::create($inserted_data);
        }
        print_r($rowData);
}


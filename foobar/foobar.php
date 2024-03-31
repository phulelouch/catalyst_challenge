<?php
  for($i=1; $i <=100; $i++){
    if(is_int($i/3) and is_int($i/5)){
      echo "foobar\n";
    }elseif(is_int($i/3)){
      echo "foo\n";
    }elseif(is_int($i/5)){
      echo "bar\n";
    } 
    else{
      echo $i."\n";
    }
  }


?>

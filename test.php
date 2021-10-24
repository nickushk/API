 <?php
    class Image{
        private $file_array;
        private $width;
        private $height;
        function __construct($file_array, $width, $height)
        {
            $this->file_array = $file_array;
            $this->width = $width;
            $this->height = $height;

                    //Kontrollerar att uppladdad bild är av rätt typ (JPEG) och att storleken
                    //inte överstiger en viss storlek - i det här fallet väldigt stor...
                    if ((($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] ==
                            "image/pjpeg")) && ($_FILES["file"]["size"] < 2000000)) {
                            if ($_FILES["file"]["error"] > 0) {
                                echo "Felmeddelande: " . $_FILES["file"]["error"] . "<br />";
                            } else {
    
                                //Kontrollerar att en bild med samma namn inte redan finns i 
                                //katalogen dit bilden skall flyttas
                                if (file_exists("images/" . $_FILES["file"]["name"])) {
                                    echo $_FILES["file"]["name"] . " finns redan. Välj ett annat filnamn.";
                                                        
                                } else {
                                
                                //Flyttar filen till rätt katalog      
                                move_uploaded_file($_FILES["file"]["tmp_name"], "images/" . $_FILES["file"]["name"]);
    
                                //Spar namn på originalbild och miniatyr i variabler
                                $storedfile = $_FILES["file"]["name"];
                                $thumbnail = "thumb_" . $_FILES["file"]["name"];
    
                                //Maximal storlek i höjd och bredd för miniatyr
                                $width_thumbnail = 350;
                                $height_thumbnail = 100;
                                                
    
                                //Läser in originalstorleken på den uppladdade bilden, och spar 
                                //den i variablerna width_orig, height_orig
                                list($width_thumbnail_orig, $height_thumbnail_orig) = getimagesize('images/' . $storedfile);
                                
                                //Räknar ut förhållandet mellan höjd och bredd (sk "ratio")
                                //Detta för att kunna få samma höjd- breddförhållande på miniatyren
                                $ratio_orig = $width_thumbnail_orig / $height_thumbnail_orig;
                                
                                //Räknar ut storlek på miniatyr
                                if ($width_thumbnail / $height_thumbnail > $ratio_orig) {
                                    $width_thumbnail = $height_thumbnail * $ratio_orig;
                                    $height_thumbnail = $width_thumbnail / $ratio_orig;
                                } else {
                                    $height_thumbnail = $width_thumbnail / $ratio_orig;
                                    $width_thumbnail = $height_thumbnail * $ratio_orig;
                                }
    
                                //Skapar en ny bild miniatyrbild med rätt storlek
                                $image_p = imagecreatetruecolor($width_thumbnail, $height_thumbnail);
                                $image = imagecreatefromjpeg('images/' . $storedfile);
                                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width_thumbnail, $height_thumbnail, $width_thumbnail_orig, $height_thumbnail_orig);
    
                                //Sparar miniatyr
                                imagejpeg($image_p, 'images/' . $thumbnail);
    
                                echo "<h3>Bild uppladdad</h3>\n";
                                echo "<a href='images/$storedfile' title='Öppna originalbild'><img src='images/thumb_$storedfile' alt='$storedfile' /></a>\n";
    
                                }
                            }
                        } 
                        else {
                    // Här hamnar man om det inte är JPEG/bildfil för stor
                    echo "Ej JPEG/Bildfilen större än 2Mb.";
                }
        }  
    }
    
  

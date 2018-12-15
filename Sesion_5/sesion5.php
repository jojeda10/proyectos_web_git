<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Sesion 5</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>  
		<h1> Galeria</h1>
		<?php
			//DEBUG
			//error_reporting(-1);
			//ini_set('display_errors', 'on');
			
			$pathRealImg 	= "photos";
			
			//clase imagen
			$image=new Image($pathRealImg);
			//pintamos las imagenes y almacenamos en un array las imagenes
			$image_List=$image->getImages();
			
			//recorremos las imagenes
			foreach ($image_List as $ImageValue)
			{	
				echo "<a href='".$ImageValue[0]."' target='_blank' style='margin-left:20px' ><img src='".$ImageValue[1]."' alt='".$ImageValue[0]."'/></a>";
			}
			
			class File
			{
				//rutas de las imagenes
				var $ruta = "/";
				var $rutaMini = "/";
				
				//constructor
				public function __construct($path)
				{
					$this->ruta 	= $path;
					$this->rutaMini = $path."/thumbs";
				}	
				
				//creamos directorios si no existen segun un ruta
				protected function createDir()
				{
					//si no existe la carpeta la creamos
					if (!file_exists($this->ruta))
					{
						mkdir($this->ruta,0777,true);	
					}
					
					//igual en las imagenes mini
					if (!file_exists($this->rutaMini))
					{
						mkdir($this->rutaMini,0777,true);		
					}	
						
				}
				
				//checkeamos si existen las miniaturas
				protected function checkIfFileExistes($file)
				{
					return (file_exists($this->rutaMini."/".$file));
				}
				
				//genero una lista de los ficheros de la ruta
				protected function getFileList()
				{
					$RealPathServer = realpath($_SERVER['DOCUMENT_ROOT']."/".$this->ruta);
					$Dir 			= opendir("$RealPathServer");
					return $Dir;		
				}		
			}
			
			class System
			{
				public function execCommand($instruccion)
				{
					echo exec($instruccion);
				}	
			}
			
			class Image extends File
			//Se convierte las imagenes a miniatura
			{		
				private function createThumb($file)
				{
					$ExecLinux = new System();
					$ExecLinux->execCommand("convert ".$this->ruta."/$file -resize 40x40 ".$this->rutaMini."/$file");		
				}
				
				private function validatePhoto($file)
				{
					//filtramos las imagenes sólo con estas extensiones
					return (preg_match('/\.(jpg|png|gif)$/', $file));
				}
				
				public function getImages()
				{
					//miramos si existe las carpetas photo y thumb
					$this->createDir();
					//sacamos la lista de ficheros de la carpeta photos
					$Dir = $this->getFileList();
					//array de salida
					$image_List = array();
					
					//recorremos el contenido de esa carpeta
					while (false !== ($file = readdir($Dir)))
					{
						//tiene que ser jpg, gif o png para que muestre las imagenes y que no sea . o ..
						if($file!="." && $file!=".." && $this->validatePhoto($file))
						{				
							//miro si existe la imagen en el thumbs si no lo creo
							if(!$this->checkIfFileExistes($file))
							{
								//como NO existe la minituara la creamos
								$this->createThumb("$file");
							}
							
							//guardo en el array la lista de imagenes
							//posicio 0 la imagen real y posicion 1 la imagen 
							$image_List[] = Array($this->ruta."/$file", $this->rutaMini."/$file");
						}		
							
					}
					
					//cerramos la carpeta
					closedir ($Dir);	

					//devolvemos la lista
					return $image_List;
				}
			}
		?>
	</body>
</html>
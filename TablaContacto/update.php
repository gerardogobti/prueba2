<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$phone = $email = $direction = $facebook = $twitter = $whatsapp = $instagram = "";
$phone_err = $email_err = $image_err = $price_err = $user_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validando el registro de nmombre
    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Por favor ingrese un nombre de estacion.";     
    } else{
        $title = $input_title;
    }

    // Validando ubicacion
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Por favor ingrese una ubicacion de la estacion.";     
    } else{
        $description = $input_description;
    }

     
    // Validando gerente en turno
    $input_image = trim($_POST["image"]);
    if(empty($input_image)){
        $image_err = "Por favor ingrese un gerente en turno actual.";     
    } else{
        $image = $input_image;
    }

    // Validando estado actual de la estacion
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Por favor ingrese un estado actual de la estacion.";     
    } else{
        $price = $input_price;
    }

    // Validando precio gasolina magna 
    $input_user = trim($_POST["user"]);
    if(empty($input_user)){
        $user_err = "Por favor ingrese un precio de la gasolina magna.";     
    } else{
        $user = $input_user;
    }

        
    // Check input errors before inserting in database
    if(empty($title_err) && empty($description_err) && empty($image_err) && empty($price_err) 
                         && empty($user_err)){
        // Prepare an update statement
        $sql = "UPDATE productsyservices SET title=?, description=?, image=?, price=?, user=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssi", $param_title, $param_description, $param_image, 
                $param_price, $param_user, $param_id);
            
            // Set parameters
            $param_title = $title;
            $param_description = $description;
            $param_image = $image;
            $param_price = $price;
            $param_user = $user;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Ocurrio un error. Intentelo mas tarde.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM productsyservices WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $title = $row["title"];
                    $description = $row["description"];
                    $image = $row["image"];
                    $price = $row["price"];
                    $user = $row["user"];
                    
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Ocurrio un error. Porfavor intentelo mas tarde.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Datos de los Productos/Servicios</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Actualizar Datos de los Productos/servicios</h2>
                    </div>
                    <p>Edite los datos de entrada y envíe para actualizar el registro de usuarios.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

                        <div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                            <label>Titulo:</label>
                            <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                            <span class="help-block"><?php echo $title_err;?></span>
                        </div>
                        
                        <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                            <label>Descripcion:</label>
                            <input type="text" name="description" class="form-control" value="<?php echo $description; ?>">
                            <span class="help-block"><?php echo $description_err;?></span>
                        </div>
                       
                       <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                            <label>Imagen:</label>
                            <textarea name="image" class="form-control"><?php echo $image; ?></textarea>
                            <span class="help-block"><?php echo $image_err;?></span>
                        </div>
                       
                        <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                            <label>Precio:</label>
                            <input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
                            <span class="help-block"><?php echo $price_err;?></span>
                        </div>
                        
                        <div class="form-group <?php echo (!empty($user_err)) ? 'has-error' : ''; ?>">
                            <label>Usuario:</label>
                            <input type="text" name="user" class="form-control" value="<?php echo $user; ?>">
                            <span class="help-block"><?php echo $user_err;?></span>
                        </div>                       
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
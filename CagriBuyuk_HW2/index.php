<!DOCTYPE html>   
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Validation</title> 
    <style>
      #formI{
        text-align:center;
        color:red;
        font-size:30px;
      }
      #formV{
        text-align:center;
        color:white;
        background:green;
        font-size:30px;
      }
      span{
        color:red;
        font-size:20px;
        margin-left:20px;
      }
      table{
         border-collapse: collapse;
      }
      td{
        padding:3px;
        text-align: left;
        border : 1px solid #666; 
        height: 25px;
      }
    </style>
</head>
<body> 
    <?php                       
    require "fruits.php";
        if(!empty($_POST))
        {
            extract($_POST);
            
            if(empty($fruitsSelected)){
                $error["selected"] = "At least one fruit must be selected";
            }
            if(empty($payment)){
                $error["payment"] = "Payment must be selected";
            }
            else
            {
                if($payment === "Visa")
                {
                    $re = '/^4\d{3}-\d{4}-\d{4}-\d{4}$/';
                    if(!preg_match($re, $regex))
                    {
                        $error["regex"] = "Visa format is invalid"; 
                    }

                }else
                {
                    $re = '/^TCKT-[a-zA-Z]{3}-\d{4,6}$/';
                    if(!preg_match($re, $regex))
                    {
                        $error["regex"] = "MultiNet format is invalid"; 
                    }
                }
            }

            if(!empty($error)){
                echo "<h1 id='formI'>Form Invalid</h1>";
            }else{
                echo "<h1 id='formV'>Form Validated</h1>";
            }
        }
    ?>
    <form action="" method="post"> 
        <h1>Fruits <span><?= $error["selected"] ?? ""?></span></h1>  
        <table> 
        <?php
        
            foreach($fruits as $fruit)
            {
                    
            echo "<tr>";                    
        ?>
            <td>
            <input type="checkbox" name="fruitsSelected[]"
            <?= isset($fruitsSelected) && in_array($fruit["name"], $fruitsSelected) ? "checked" : "" ?>>
            <label><?= $fruit["name"]?> - <?= $fruit["price"]?> &#8378;</label>
            </td>
        <?php
            echo "</tr>";
            }
        ?>
            
        </table>
        <section>
            <h1>Payment Method <span><?= $error["payment"] ?? "" ?></span></h1>
            <input type="radio" name="payment" value="Visa"
                <?= isset($payment) && $payment == "Visa" ? "checked" : "" ?>
            >
            <label>VISA</label>
            <input type="radio" name="payment" value="MultiNet"
                <?= isset($payment) && $payment == "MultiNet" ? "checked" : "" ?>
            >
            <label>MultiNet</label>
        </section>
        <div>
            <h1>VISA/MultiNet<span><?= $error["regex"] ?? "" ?></span></h1>
            <input type="text" name="regex" 
                value ="<?= $regex ?? ""?>"
            >
        </div>
        <button>Pay!!</button>
        
    </form>
</body>
</html>
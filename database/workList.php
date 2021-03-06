<?php

include "config.php";

?>

    <nav class="navbar navbar-light bg-light">
        <button type="button" class="btn btn-primary">
            Total Work <span class="badge badge-light">
            <?php
                $sql = "SELECT * FROM `work_detail` ORDER BY Id DESC";
                $result = $con -> query($sql);

                $rowcount = mysqli_num_rows($result);
                if($rowcount > 0){
                    echo $rowcount;
                }else{
                    echo "No Record Found";
                }
            ?>
            </span>
        </button>
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" id="visitor_search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </nav>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
            <th scope="col">Id</th>
            <th scope="col">Work</th>
            <th scope="col">Category</th>                        
            <th scope="col">Add Date</th>
            <th scope="col">Status</th>
            <th scope="col">Karykarta</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="worklist_table_body">

        <?php

            if($result->num_rows>0)
            {
                $i = 1;  

                while($row=$result->fetch_assoc())
                {
                    
                    echo "<tr>";
                    echo "<th scope='row'>$i</th>";
                    echo "<td>{$row['Work_title']}</td>";
                    echo "<td>{$row['Work_Category']} | <br>{$row['Work_Subcategory']}</td>";
                    echo "<td>{$row['Work_add_date']}</td>";
                    echo "<td>{$row['Status']}</td>";  
                    echo "<td>Sumit Mahamuni <br> +91 987456321 </td>";       
                    echo "<td><button type='button' class='btn btn-primary btn-sm edit' data-toggle='modal' data-target='#exampleModalCenter' data-id='{$row['Id']}'><i class='fa fa-pencil' aria-hidden='true'></i></button>";
                    echo "<button type='button' class='btn btn-danger btn-sm ml-2 remove' data-id='{$row['Id']}'><i class='fa fa-trash' aria-hidden='true'></button>";
                    echo "</td>";
                    echo "</tr>";

                    $i++;

                }

            }

            else{

                echo "No Data Fonund";

            }

            $con->close();
        
        ?>

            <!-- <tr>
            <th scope="row">1</th>
            <td>Need Road Development</td>
            <td>Government |<br> Road</td>
            <td>07/01/2020</td>
            <td>Pending</td>
            <td>Sumit Mahamuni <br>+91 9632587410</td>
            <td>
                <button type='button' class='btn btn-primary btn-sm edit'><i class="fa fa-pencil" aria-hidden="true"></i></button>
                <button type='button' class='btn btn-danger btn-sm ml-2 remove'><i class="fa fa-trash" aria-hidden="true"></i></button>
            </td>
            </tr> -->

        </tbody>
    </table>

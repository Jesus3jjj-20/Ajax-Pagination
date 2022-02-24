<?php 
if(isset($_POST['page'])){ 
    // Include pagination library file 
    include_once 'paginationLibrary.php'; 
     
    // Include database configuration file 
    require_once 'dbConfig.php'; 
     
    // Set some useful configuration 
    $baseURL = 'getData.php'; 
    $offset = !empty($_POST['page'])?$_POST['page']:0; 
    $limit = 7; 
     
    // Set conditions for search 
    $whereSQL = ''; 
    if(!empty($_POST['keywords'])){ 
        $whereSQL = " WHERE (descriptions LIKE '%".$_POST['keywords']."%') "; 
    } 
    
    if(isset($_POST['sortBy']) && $_POST['sortBy'] != ''){ 
        $whereSQL .= " ORDER BY descriptions " . $_POST['sortBy']; 
    } 
    
     
    // Count of all records 
    $query   = $db->query("SELECT COUNT(*) as rowNum FROM data_pagination ".$whereSQL); 
    $result  = $query->fetch_assoc(); 
    $rowCount= $result['rowNum']; 

     
    // Initialize pagination class 
    $pagConfig = array( 
        'baseURL' => $baseURL, 
        'totalRows' => $rowCount, 
        'perPage' => $limit, 
        'currentPage' => $offset, 
        'contentDiv' => 'dataContainer', 
        'link_func' => 'searchFilter' 
    ); 
    $pagination =  new Pagination($pagConfig); 
 
    // Fetch records based on the offset and limit 
    $query = $db->query("SELECT * FROM data_pagination $whereSQL LIMIT $offset,$limit"); 

?> 
    <!-- Data list container --> 
    <table id="prueba" class="table table-striped"> 
    </thead> 
    <tbody> 
        <?php 
        if($query->num_rows > 0){ 
            while($row = $query->fetch_assoc()){ 
                $offset++ 
        ?> 
            <tr class="post-list"> 
                <td class="list-item"><a href="#">(id = <?php echo $row["id"];?>) <?php echo $row["descriptions"]; ?></a></td> 
            </tr> 
        <?php 
            } 
        }else{ 
            echo '<tr><td colspan="6">No records found...</td></tr>'; 
        } 
        ?> 
    </tbody> 
    </table> 
     
    <!-- Display pagination links --> 
    <?php echo $pagination->createLinks(); ?> 
<?php 
}else{
    echo "Hola";
}
?>
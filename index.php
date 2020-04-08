<?php


require("config.php");


  $results = array();
  $data = Lists::getList(100);


  $results['lists'] = $data['results'];
  $results['totallists'] = $data['totallists'];


  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
  }
include "header.php"; ?>

<body>
	<div class="container">

    <?php if ( isset( $results['statusMessage'] ) ) { ?>

      <div class="alert alert-success alert-dismissible">

        <?php echo $results['statusMessage']  ?>
    <span class='closebtn' onclick='this.parentElement.style.display="none";'>&times;</span>
      </div>
    <?php } ?>

		<h1>To-Do List</h1>

    <table>
      <tr>
        <th>Name</th>

      </tr>

    <?php foreach ( $results['lists'] as $list ) { ?>
      <tr>
        <td><?php echo $list->name?></td>

      </tr>
    <?php } ?>
    </table>
<?php $test =   Task::getById((int) 2);
 echo  $test->description;
?>



		<p><?php echo $results['totallists']?> list<?php echo ( $results['totallists'] != 1 ) ? 's' : '' ?> total.</p>


	</div>
</body>
</html>

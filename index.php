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
        <th></th>

      </tr>

    <?php foreach ( $results['lists'] as $list ) {
      $listNumber = $list->id ?>
      <tr>
        <td><b><?php echo $list->name?></b></td>
        <?php $taskData = Task::getByList((int) $listNumber);
          $results['tasks'] = $taskData['results']; ?>



          <?php foreach ( $results['tasks'] as $task ) { ?>
            <tr>
              <td><?php echo $task->description ?></td>
              <td><?php echo $task->duration ?></td>
              <td><?php echo $task->status ?></td>

            </tr>
          <?php } ?>
      </tr>
      <tr>

      </tr>

    <?php } ?>
    </table>





		<p><?php echo $results['totallists']?> list<?php echo ( $results['totallists'] != 1 ) ? 's' : '' ?> total.</p>


	</div>
</body>
</html>

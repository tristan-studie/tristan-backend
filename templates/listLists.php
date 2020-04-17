<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  </head>
  <body>
  	<div class="container">

      <?php if ( isset( $results['statusMessage'] ) ) { ?>

        <div class="alert alert-success alert-dismissible">

          <?php echo $results['statusMessage']  ?>
      <span class='closebtn' onclick='this.parentElement.style.display="none";'>&times;</span>
        </div>
      <?php } ?>

  		<h1>To-Do List</h1>
      <button onclick="window.location.href='index.php?action=newList'" type="button">

        New List
      </button>
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



  	</div>
  </body>

</html>

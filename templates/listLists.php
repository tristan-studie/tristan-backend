<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script type="text/javascript">
    function sortStatus(){
};
      </script>
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

          <td><b><a href="index.php?action=editList&listId= <?php echo $list->id ?>"><?php echo $list->name?></a></b></td>
          <?php $taskData = Task::getByList((int) $listNumber);
            $results['tasks'] = $taskData['results']; ?>
            <tr>
            <th>Name</th>
            <th>Duration</th>
            <th onclick="sortStatus()">Status</th>
            </tr>

            <?php foreach ( $results['tasks'] as $task ) { ?>
              <tr>
                <td><a href="index.php?action=editTask&listId=<?php echo $list->id ?>&taskId= <?php echo $task->id ?>"><?php echo $task->description ?></a></td>
                <td><?php echo $task->duration ?></td>
                <td><?php echo $task->status ?></td>

              </tr>
            <?php } ?>
                  <tr><td><button onclick="window.location.href='index.php?action=newTask&listId= <?php  echo $list->id?>'" type="button">Add Task</td></tr>
        </tr>
        <tr>

        </tr>

      <?php } ?>
      </table>



  	</div>
  </body>

</html>

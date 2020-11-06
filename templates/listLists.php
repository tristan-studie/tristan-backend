<?php require (TEMPLATE_PATH . "/include/header.php"); ?>
  	<div class="container">

      <?php if (isset($results['statusMessage']))
{ ?>

        <div class="alert alert-success alert-dismissible">

          <?php echo $results['statusMessage'] ?>
      <span class='closebtn' onclick='this.parentElement.style.display="none";'>&times;</span>
        </div>
      <?php
} ?>

  		<h1>To-Do List</h1>
      <button class="btn btn-primary" onclick="window.location.href='index.php?action=newList'" type="button">
        New List
      </button>
      <button onclick="window.location.href='index.php?sortFilter=<?php if (!$_POST['sortFilter'])
{
    $_POST['sortFilter'];
} ?>&sortStatus=<?php if ($_GET['sortStatus'] == 'ASC' || !$_GET['sortStatus'])
{
    $sortStatus = 'DESC';
}
else
{
    $sortStatus = 'ASC';
};
echo $sortStatus
?>'" type="button" name="sortStatus">Sort</button>

<form class="" action="index.php" method="post">
  <select    name="sortFilter" id="status" required value="" >
    <?php
foreach ($results['status'] as $statusList)
{

?>
      <option value="<?php echo $statusList->status ?>"> <?php echo $statusList->status ?></option>


     <?php
} ?>
     <option value="none">None</option>
  </select>
  <button type="submit" name="button">Submit</button>
</form>

      <table class="table table-sm table-borderless">


      <?php foreach ($results['lists'] as $list)
{
    $listNumber = $list->id ?>
        <tr>

          <td><b><a href="index.php?action=editList&listId= <?php echo $list->id ?>"><?php echo $list->name ?></a></b></td>
          <?php $taskData = Task::getByList((int)$listNumber, $_GET['sortStatus'], $_POST['sortFilter']);
    $results['tasks'] = $taskData['results']; ?>
            <tr>
            <th>Name</th>
            <th>Duration</th>
            <th onclick="sortStatus()">Status</th>
            </tr>

            <?php foreach ($results['tasks'] as $task)
    { ?>
              <tr>
                <td><a href="index.php?action=editTask&listId=<?php echo $list->id ?>&taskId= <?php echo $task->id ?>"><?php echo $task->description ?></a></td>
                <td><?php echo $task->duration ?></td>
                <td><?php echo $task->status ?></td>

              </tr>
            <?php
    } ?>
                  <tr><td><button class="btn btn-secondary btn-sm" onclick="window.location.href='index.php?action=newTask&listId= <?php echo $list->id ?>'" type="button">Add Task</td></tr>
        </tr>


      <?php
} ?>
      </table>



  	</div>
    <?php require (TEMPLATE_PATH . "/include/footer.php"); ?>

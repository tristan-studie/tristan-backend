

<main>

      <h1><?php echo $results['pageTitle']?></h1>

      <form action="index.php?action=<?php echo $results['formAction']?>" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="taskId" value="<?php echo $results['list']->id ?>"/>

<?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>

        <ul>

          <li>
            <label for="description">Task Name</label>
            <input type="text" name="description" id="description" placeholder="Name of the Task" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['list']->description )?>" />
          </li>

          <li>
            <label for="duration">Task Duration</label>
            <input type="text" name="duration" id="duration" placeholder="Duration of the Task" required maxlength="255" value="<?php echo htmlspecialchars( $results['list']->duration )?>" />
          </li>
          <li>
            <label for="status">Task Status</label>
            <select name="status" id="status" required value="<?php echo htmlspecialchars( $results['list']->status )?>" >
              <?php

              foreach ($results['status'] as $statusList) {

                ?>
                <option value="<?php echo $statusList->status ?>"> <?php echo $statusList->status ?></option>


               <?php } ?>
            </select>
          </li>
          <li>
            <label for="list_id">lijst</label>
            <input type="text" name="list_id" id="list_id" placeholder="List" required maxlength="255" value="<?php echo htmlspecialchars( $_GET['listId'])?>" />
          </li>



        </ul>

        <div class="buttons">
          <input type="submit" name="saveChanges" value="Save Changes" />
          <input type="submit" formnovalidate name="cancel" value="Cancel" />
        </div>

      </form>
      <?php if ( $results['list']->id ) { ?>
        <form action="index.php?action=deleteTask" method="post"  enctype="multipart/form-data" >

<input type="hidden" name="taskId" value="<?php echo $results['list']->id ?>"/>
            <input type="submit" name="deleteTask" value="Delete Task" onclick="return confirm('Delete This task?')"></input>
            </form>
            <?php } ?>
    </div>
  </main>

<?php require (TEMPLATE_PATH . "/include/header.php"); ?>
<main>

      <h1><?php echo $results['pageTitle'] ?></h1>

      <form action="index.php?action=<?php echo $results['formAction'] ?>" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="listId" value="<?php echo $results['list']->id ?>"/>

<?php if (isset($results['errorMessage']))
{ ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php
} ?>

        <ul>

          <li>
            <label for="name">List Name</label>
            <input type="text" name="name" id="name" placeholder="Name of the list" required autofocus maxlength="255" value="<?php echo htmlspecialchars($results['list']->name) ?>" />
          </li>



        </ul>

        <div class="buttons">
          <input type="submit" name="saveChanges" value="Save Changes" />
          <input type="submit" formnovalidate name="cancel" value="Cancel" />
        </div>

      </form>
      <?php if ($results['list']->id)
{ ?>
        <form action="index.php?action=deleteList" method="post"  enctype="multipart/form-data" >

<input type="hidden" name="listId" value="<?php echo $results['list']->id ?>"/>
            <input type="submit" name="deleteList" value="Delete List" onclick="return confirm('Delete This list?')"></input>
            </form>
            <?php
} ?>
    </div>
  </main>
<?php require (TEMPLATE_PATH . "/include/footer.php"); ?>

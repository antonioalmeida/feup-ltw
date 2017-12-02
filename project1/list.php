<?php
include_once('includes/init.php');
include_once('database/user.php');
include_once('database/lists.php');
include_once('templates/common/header.php');
?>

<script type="text/javascript" src="scripts/items.js" defer></script>

<?php
include_once('templates/common/navbar.php');

$isLoggedIn = (isset($_SESSION['username']));
$username = $_SESSION['username'];
$user = getUser($username);

if (!isset($_GET['id']))
  die("No id!");

if ( !preg_match ("/^\d+$/", $_GET['id'])) {
  die("ERROR: ID can only contain numbers");
}

$listID = $_GET['id'];
$list = getUserList($user['username'], $listID);
$items = getListItems($listID);
?>

<div class="container">
  <div class="flex-container">
    <div class="sidebar">
      <h6><strong>Menu</strong></h6>
      <p><i class="fa fa-user-plus"></i> <strong>Invite Users</strong></p>
      <div class="form-element ">
        <input type="text" placeholder="Username" name="addMember" value="<?=$item['description']?>" required>
      </div>
      <p><i class="fa fa-calendar-check-o"></i> <strong>Due Today</strong></p>
    </div>

    <div class="items">
      <?php if ($isLoggedIn) { ?>
      <h4>
        <?=$list['title']?>
      </h4>

      <?php } else { ?>
      <!-- else here -->
      <?php } ?>
      <?php foreach($items as $item) { ?>
      <div class="item" id="item<?=$item['id']?>">
        <div class="item-left">
          <input type="checkbox" id="<?=$item['id']?>" name="complete"
          <?php if($item['complete'] == 1) { ?>
          checked
          <?php } ?>
          >
          <span class="itemDescription"><?=$item['description']?></span>
          <span clas="itemDueDate"><?= date('d M', strtotime($item['dueDate']))?></span>
        </div>

        <div class="item-edit hidden">
          <form class="editItemForm">
            <div class="flex-equal">
              <input type="hidden" name="itemID" value="<?=$item['id']?>">
              <div>
                <label for="editDescription">Description</label>
                <input type="text" name="editDescription" value="<?=$item['description']?>" required>
              </div>
              <div>
                <label for="editDate">Due Date</label>
                <input type="date" name="editDate" value="<?=$item['dueDate']?>" required>
              </div>
            </div>
            <div>
              <input class="button-primary" type="submit" value="Save">
              <a class="button cancelEditItem">Cancel</a>
            </div>
          </form>
        </div>

        <div class="item-right">
          <span><i id="assignUser<?=$item['id']?>" class="fa fa-user-plus"></i></span>
          <span><i id="edit<?=$item['id']?>" class="fa fa-pencil-square-o"></i></span>
          <span><i id="delete<?=$item['id']?>" class="fa fa-trash"></i></span>
        </div>
      </div>
      <?php } ?>

      <div class="add-item">
        <a href="#" id="showAddItem"><i class="fa fa-plus"></i> Add a Task</a>
        <div>
          <form class="hidden" id="addItemForm">
            <div>
              <input type="hidden" name="id" value="<?=$listID?>">
              <br>
              <div>
                <label for="description">Description</label>
                <input type="text" placeholder="Call girlfriend" name="description" required>
              </div>
            </div>
            <div>
              <input class="button-primary" type="submit" value="Add">
              <a id="cancelAddItem" class="button">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div> <!-- end .items -->

</div>

<?php
include('templates/common/footer.php');
?>

<?php
session_start();
include('../db/database-connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve_order']) || isset($_POST['delete_order'])) {
        $orderId = $_POST['order_id'];

        $action = isset($_POST['approve_order']) ? 'approve' : 'delete';

        switch ($action) {
            case 'approve':
                $status = 'Approved';
                break;
            case 'delete':
                $deleteQuery = "DELETE FROM Orders WHERE order_id = ?";
                $deleteStmt = $conn->prepare($deleteQuery);
                $deleteStmt->bind_param("i", $orderId);

                if ($deleteStmt->execute()) {
                } else {
                    echo "Error deleting order: " . $deleteStmt->error;
                    exit();
                }

                $deleteStmt->close();
                break; 
            default:
                echo "Invalid action.";
                exit();
        }

        // Update the order status
        $updateQuery = "UPDATE Orders SET status = ? WHERE order_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("si", $status, $orderId);

        if ($updateStmt->execute()) {
        } else {
            echo "Error updating order: " . $updateStmt->error;
            exit(); 
        }

        $updateStmt->close();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Admin Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
</head>
<body>

    <?php
    include('../components/admin-header.php');
    ?>

    <div class="admin-container">
      <aside class="sidebar">
        <ul class="sidebar__links">
          <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="products.php">Products</a></li>
          <li><a href="orders.php" class="active">Orders</a></li>
          <li><a href="messages.php">Messages</a></li>
          <li><a href="logs.php">Logs</a></li>
        </ul>
      </aside>

      <main class="admin-content">
        <div class="admin-header">
          <h1>Order Management</h1>
          <a href="create-order.php" class="add-product-link">
                <button class="add-product-btn">Add Order</button>
          </a>
        </div>

        <div class="table-container">
          <table class="responsive-table" id="orderTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT o.order_id, u.username AS customer_name, p.title AS product_name, o.quantity, o.total_price, o.status
                    FROM Orders o
                    JOIN Users u ON o.user_id = u.user_id
                    JOIN Products p ON o.product_id = p.product_id";
                $result = $conn->query($query);

                if ($result === false) {
                    die("Error: " . $conn->error);
                }

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $row['order_id']; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>$<?php echo $row['total_price']; ?></td>
                        <td>
                            <span class="order-status"><?php echo $row['status']; ?></span>
                        </td>
                        <td>
                            <form method="post" onsubmit="return confirm('Are you sure you want to approve this order?');" style="display: contents;">
                                <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                                <button type="submit" name="approve_order" class="crud-btn approve-btn edit-btn">Approve</button>
                            </form>
                            <form method="post" onsubmit="return confirm('Are you sure you want to delete this order?');" style="display: contents;">
                                <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                                <button type="submit" name="delete_order" class="crud-btn delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php
                    }
                } else {
                ?>
                    <tr>
                        <td colspan="7">No orders found.</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </body>
</html>

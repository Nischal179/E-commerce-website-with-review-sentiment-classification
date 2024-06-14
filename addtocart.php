<?php

include 'core/connection.php';

$cart = [];
if ( isset( $_GET['id'] ) && $_GET['id'] !== '' ) {

	if ( isset( $_COOKIE['my_cart'] ) ) {
		$cart = explode( ',', $_COOKIE['my_cart'] );
	}

	$cart[] = $_GET['id'];

	$cart = array_unique( $cart );
	setcookie( 'my_cart', implode( ',', $cart ), time() + ( 24 * 7 * 3600 ) );
} else {
	if ( isset( $_COOKIE['my_cart'] ) ) {
		$cart = explode( ',', $_COOKIE['my_cart'] );
	}
}


                            if ( count( $cart ) > 0 ) {
                                $sql = 'SELECT * FROM product WHERE PRODUCT_ID IN (' . implode(',', $cart) . ')';
                                $query = oci_parse($conn, $sql);

                                oci_execute($query);
                                $i = 1;
                                echo '              <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                </tr>
                                </thead>
                                <tbody>';
                                while ($row = oci_fetch_assoc($query)) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row['PRODUCT_ID']; ?></td>
                                        <td><?php echo $row['PRODUCT_NAME']; ?></td>
                                        <td>Rs/- <?php echo $row['PRODUCT_PRICE']; ?></td>
                                    </tr>
                                    <?php $i++;
                                }
                                echo '                  </tbody>
								</table>';
								header("Location: {$_SERVER['HTTP_REFERER']}");
                            }else{
                                echo "Nothing to show";
                            }


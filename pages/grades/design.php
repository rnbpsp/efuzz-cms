<?php ?>
<!DOCTYPE html>
<html>
	<head>
		<title>grades</title>
		<style>
			td, th {
				padding: 6px 12px;
			}
			th {
				border: 0 solid black;
				border-bottom: 2px;
			}
			table {
				border: 3px solid black;
				margin: 0px auto;
				padding: 6px;
				text-align: center;
				border-collapse: collapse;
				vertical-align: bottom;
			}
		</style>
	</head>
	<body>
		<table>
			<tr>
				<th rowspan=2>USN</th>
				<th colspan=3>Prelim</th>
			</tr>
			<tr>
				<th>Q1</th>
				<th>Q2</th>
				<th>Exam</th>
			</tr>
			<?php
				require_once "config.php";
				$sql = "SELECT uname, pq1_grd, pq2_grd, pexam_grd FROM stud_grade";
				$result = $conn->query($sql);
				
				$alt = false;
				$titles = array('USN', 'Prelim Q1', 'Prelim Q2', 'Prelim Exam');
				$vals = array('uname', 'pq1_grd', 'pq2_grd', 'pexam_grd');
				
				if ($result->num_rows > 0)
					while ($row = $result->fetch_assoc())
					{
						if ($alt)
							echo '<tr>';
						else
							echo '<tr style="background-color:#a0a0a0;color:white">';
						
						$i=0;
						foreach($vals as $val)
						{
							if ( empty($row[$val]) )
							{
								if ($alt)
									echo '<td style="background:red" title="' . $titles[$i++] . '">N/A</td>';
								else
									echo '<td style="background:maroon" title="' . $titles[$i++] . '">N/A</td>';
							}
							else
								echo '<td title="' . $titles[$i++] . '">' . $row[$val] .'</td>';
						}
						$alt = !$alt;
						echo "</tr> <br>";
					}
			?>
		</table>
	</body>
</html>

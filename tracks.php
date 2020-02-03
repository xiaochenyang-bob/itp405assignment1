<?php
	if (!isset($_GET['playlist']))
	{
		header('Location: index.php');
      	exit();
	}
	$pdo = new PDO('sqlite:chinook.db');
	$sql = "SELECT tracks.Name AS trackName,
			albums.title AS albumTitle,
			artists.Name AS artistName,
			tracks.UnitPrice AS price,
			media_types.Name AS media_typeName,
			genres.Name AS genreName
			FROM playlist_track
			JOIN tracks ON playlist_track.TrackId = tracks.TrackId
			JOIN albums ON albums.AlbumId = tracks.AlbumId
			JOIN artists ON artists.ArtistId = albums.ArtistId
			JOIN media_types ON media_types.MediaTypeId = tracks.MediaTypeId
			JOIN genres ON genres.GenreId = tracks.GenreId
			WHERE playlist_track.PlaylistId = ?";
	$statement = $pdo->prepare($sql);
    $statement->bindParam(1, $_GET['playlist']);
    $statement->execute();
    $tracks = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<table>
  <thead>
    <th>Track name</th>
    <th>Album title</th>
    <th>Artist name</th>
    <th>Price</th>
    <th>Media type name</th>
    <th>Genre name</th>
  </thead>
  <tbody>
    <?php foreach($tracks as $track) : ?>
      <tr>
        <td><?php echo $track->trackName ?></td>
        <td><?php echo $track->albumTitle ?></td>
        <td><?php echo $track->artistName ?></td>
        <td><?php echo $track->price ?></td>
        <td><?php echo $track->media_typeName ?></td>
        <td><?php echo $track->genreName ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>
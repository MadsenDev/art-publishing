<?php
    function generateAlbumOptions($albums, $parent_id = null, $indent = "", $selected_album = null) {
        $options = "";
    
        foreach ($albums as $album) {
            if ($album['parent_album'] == $parent_id) {
                $selected = ($selected_album !== null && $selected_album == $album['id']) ? 'selected' : '';
                $options .= "<option value=\"{$album['id']}\" $selected>{$indent}{$album['name']}</option>";
                $options .= generateAlbumOptions($albums, $album['id'], $indent . "--", $selected_album);
            }
        }
    
        return $options;
    }

    function generateAlbumTableRows($albums, $parent_id = null, $indent = "", $indentStep = "&emsp;") {
        $rows = "";
        foreach ($albums as $album) {
            if ($album['parent_album'] == $parent_id) {
                $name = htmlspecialchars($album['name']);
                $description = htmlspecialchars($album['description']);
                $rows .= "<tr>
                            <td>{$indent}{$name}</td>
                            <td>{$description}</td>
                            <td>
                                <a href=\"edit_album.php?id={$album['id']}\">Edit</a>
                                <a href=\"delete_album.php?id={$album['id']}\">Delete</a>
                            </td>
                        </tr>";
                $rows .= generateAlbumTableRows($albums, $album['id'], $indent . $indentStep, $indentStep);
            }
        }
        return $rows;
    }

    function generateAlbumListItems($albums, $parent_id = null, $indent = "", $indentStep = "&emsp;") {
        $listItems = "";
        foreach ($albums as $album) {
            if ($album['parent_album'] == $parent_id) {
                $name = htmlspecialchars($album['name']);
                $listItems .= "<li><a href=\"manage_images.php?album_id={$album['id']}\">{$indent}{$name}</a></li>";
                $listItems .= generateAlbumListItems($albums, $album['id'], $indent . $indentStep, $indentStep);
            }
        }
        return $listItems ? "<ul class=\"album-list\">{$listItems}</ul>" : "";
    }
?>
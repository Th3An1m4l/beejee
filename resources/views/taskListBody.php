<?php foreach ($taskList as $task):?>
    <tr class="editableRow" data-id="<?=$task["id"]?>" data-description="<?=$task["description"]?>" data-status="<?=$task["status"]?>">
        <th scope="row"><?=$task["id"]?></th>
        <td><?=$task["username"]?></td>
        <td><?=$task["email"]?></td>
        <td><?=$task["description"]?></td>
        <td><?=$task["status"]?></td>
        <td><?=date_format(DateTime::createFromFormat('U', $task["created_at"]), "Y/m/d H:i:s")?></td>
        <td><? if($task["updated_at"]) echo date_format(DateTime::createFromFormat('U', $task["updated_at"]),"Y/m/d H:i:s"); else echo "never";?></td>
    </tr>
<?php endforeach?>
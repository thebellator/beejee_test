<div class="%class%" role="alert">
    %finished_alert%
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4 well well-sm">
            <form action="functions.php" method="post" class="form" role="form">
                <input type="hidden" name="edit_task" value="%task_id%" />
                <input class="form-control" name="user_name" value="%user_name%" placeholder="Введите Имя" type="text" />
                <input class="form-control" name="user_email" value="%user_email%" placeholder="Введите Email" type="email" />
                <textarea name="task_text" id="message" class="form-control"
                          rows="9" cols="25" required="required"
                          placeholder="Текст задачи">%task_text%</textarea>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Изменить</button>
            </form>
            <form action="functions.php" method="post" class="form" role="form">
                <input type="hidden" name="completed_task" value="%task_id%" />
                <button class="btn btn-success" type="submit">Выполнено</button>
            </form>
        </div>
    </div>
</div>
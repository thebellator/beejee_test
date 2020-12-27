<div class="%class%" role="alert">
    %add_alert_txt%
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4 well well-sm">
            <form action="functions.php" method="post" class="form" role="form">
                <input type="hidden" name="add_task" value="true" />
                <input class="form-control" name="user_name" placeholder="Введите Имя" type="text" />
                <input class="form-control" name="user_email" placeholder="Введите Email" type="email" />
                <textarea name="task_text" id="message" class="form-control"
                          rows="9" cols="25" required="required"
                          placeholder="Текст задачи"></textarea>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Добавить</button>
            </form>
        </div>
    </div>
</div>
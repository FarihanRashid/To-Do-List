<div class="copyright-sec bg-dark">
    <div class="container">
        <div class="row text-white pt-2 pb-2">
            <div class="col-md-6 text-start`">
                <h6>This is a To-Do List for practice purposes.</h6>
            </div>
            <div class="col-md-6 text-end">
                <h6>Designed and Developed by - Farihan Rashid</h6>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script>
    function dropDown(num) {
        $(`#drop_down_${num}`);
        if ($(`#drop_down_${num}`).hasClass('show')) {
            $(`#drop_down_${num}`).removeClass('show');
            $(`#drop_down_${num}`).addClass('hide');
        } else {
            $(`#drop_down_${num}`).removeClass('hide');
            $(`#drop_down_${num}`).addClass('show');
            console.log("Hello");
        }
    }

    function formDetailsUpdate(id) {
        var task_name = $(`#task_name_update${id}`).val();
        var due_date = $(`#due_date_update${id}`).val();
        var link = `./update_task_details.php?id=${id}&task_name=${task_name}&due_date=${due_date}`;
        window.open(link);
    }

    $(function() {
        $('#myTable').DataTable({
            paging: false,
            ordering: false
        });
    });
</script>
</body>

</html>
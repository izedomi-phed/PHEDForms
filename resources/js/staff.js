$(document).ready(function () {

    var count = 0;
    var countf = 0;
    var countc = 0;
    var countp = 0;
    var countt = 0;
    var c;

    count++
    countf++
    countc++
    countp++
    countt++
    //dynamic_field(1, "all");
    financial(1);
    customer(1);
    process(1);
    training(1);
    behaviour(1);

    function financial(number) {
        c = number

        var html = "<tr id='rem-fdt-" + c + "'>";
        html += "<td><input type='text' name='title_f[]' class='form-control' required/></td>";
        html += "<td><input type='text' name='target_planned_f[]' class='form-control' required /></td>";
        html += "<td><input type='text' name='target_achieved_f[]' class='form-control' required /></td>";
        html += "<td>";
        html += "<select name='rating_by_self_f[]' class='form-control' required>";
        html += "<option value=''></option>";
        html += "<option>1</option>";
        html += "<option>2</option>";
        html += "<option>3</option>";
        html += "<option>4</option>";
        html += "<option>5</option>";
        html += "</select></td>";
        html += "<td><input type='text' name='rating_by_appraisal_f[]' class='form-control' readonly /></td>";
        html += "<td><input type='text' name='rating_by_reviewer_f[]' class='form-control' readonly /></td>";


        if (c > 1) {
            html += "<td><button type='button' class='btn btn-danger fdt' id='fdt'><i class='fa fa-times'></i></button></td></tr>";
        }

        $('#body_fdt').append(html);

    }

    function customer(number) {
        c = number

        var html = "<tr id='rem-cdt-" + c + "'>";
        html += "<td><input type='text' name='title_c[]' class='form-control' required/></td>";
        html += "<td><input type='text' name='target_planned_c[]' class='form-control' required /></td>";
        html += "<td><input type='text' name='target_achieved_c[]' class='form-control' required /></td>";
        html += "<td>";
        html += "<select name='rating_by_self_c[]' class='form-control' required>";
        html += "<option value=''></option>";
        html += "<option>1</option>";
        html += "<option>2</option>";
        html += "<option>3</option>";
        html += "<option>4</option>";
        html += "<option>5</option>";
        html += "</select></td>";
        html += "<td><input type='text' name='rating_by_appraisal_c[]' class='form-control' readonly /></td>";
        html += "<td><input type='text' name='rating_by_reviewer_c[]' class='form-control' readonly /></td>";


        if (c > 1) {
            html += "<td><button type='button' class='btn btn-danger cdt' id='cdt'><i class='fa fa-times'></i></button></td></tr>";
        }

        $('#body_cdt').append(html);

    }

    function process(number) {
        c = number

        var html = "<tr id='rem-pdt-" + c + "'>";
        html += "<td><input type='text' name='title_p[]' class='form-control' required/></td>";
        html += "<td><input type='text' name='target_planned_p[]' class='form-control' required /></td>";
        html += "<td><input type='text' name='target_achieved_p[]' class='form-control' required /></td>";
        html += "<td>";
        html += "<select name='rating_by_self_p[]' class='form-control' required>";
        html += "<option value=''></option>";
        html += "<option>1</option>";
        html += "<option>2</option>";
        html += "<option>3</option>";
        html += "<option>4</option>";
        html += "<option>5</option>";
        html += "</select></td>";
        html += "<td><input type='text' name='rating_by_appraisal_p[]' class='form-control' readonly /></td>";
        html += "<td><input type='text' name='rating_by_reviewer_p[]' class='form-control' readonly /></td>";


        if (c > 1) {
            html += "<td><button type='button' class='btn btn-danger pdt' id='pdt'><i class='fa fa-times'></i></button></td></tr>";
        }

        $('#body_pdt').append(html);

    }

    function training(number) {
        c = number

        var html = "<tr id='rem-tdt-" + c + "'>";
        html += "<td><input type='text' name='title_t[]' class='form-control' required/></td>";
        html += "<td><input type='text' name='target_planned_t[]' class='form-control' required /></td>";
        html += "<td><input type='text' name='target_achieved_t[]' class='form-control' required /></td>";
        html += "<td>";
        html += "<select name='rating_by_self_t[]' class='form-control' required>";
        html += "<option value=''></option>";
        html += "<option>1</option>";
        html += "<option>2</option>";
        html += "<option>3</option>";
        html += "<option>4</option>";
        html += "<option>5</option>";
        html += "</select></td>";
        html += "<td><input type='text' name='rating_by_appraisal_t[]' class='form-control' readonly /></td>";
        html += "<td><input type='text' name='rating_by_reviewer_t[]' class='form-control' readonly /></td>";


        if (c > 1) {
            html += "<td><button type='button' class='btn btn-danger tdt' id='tdt'><i class='fa fa-times'></i></button></td></tr>";
        }

        $('#body_tdt').append(html);

    }

    function behaviour(number) {
        c = number

        var html = "<tr id='rem-bdt-" + c + "'>";
        html += "<td>";
        html += "<select name='title_b[]' class='form-control' required>";
        html += "<option value=''></option>";
        html += "<option>Interpersonal skill: Willingness to help others, Relation with peers</option>";
        html += "<option>Communication skill: Thought clarity, Uses data, Ability to influence</option>";
        html += "<option>Team Spirit: Cooperate with others, Provide guidance and direction to others, Take responsibility and ownership</option>";
        html += "</select></td>";
        html += "<td>";
        html += "<select name='rating_by_self_b[]' class='form-control' required>";
        html += "<option value=''></option>";
        html += "<option>1</option>";
        html += "<option>2</option>";
        html += "<option>3</option>";
        html += "<option>4</option>";
        html += "<option>5</option>";
        html += "</select></td>";
        html += "<td><input type='text' name='rating_by_appraisal_b[]' class='form-control' readonly /></td>";
        html += "<td><input type='text' name='rating_by_reviewer_b[]' class='form-control' readonly /></td>";


        if (c > 1) {
            html += "<td><button type='button' class='btn btn-danger bdt' id='bdt'><i class='fa fa-times'></i></button></td></tr>";
        }

        $('#body_bdt').append(html);

    }


    //add element

    $('#add_fdt').click(function (event) {
        event.preventDefault();
        countf++;
        financial(countf);
    });

    $('#add_cdt').click(function (event) {
        event.preventDefault();
        countc++;
        customer(countc);
    });
    $('#add_pdt').click(function (event) {
        event.preventDefault();
        countp++;
        process(countp);
    });
    $('#add_tdt').click(function (event) {
        event.preventDefault();
        countt++;
        training(countt);
    });
    $('#add_bdt').click(function (event) {
        event.preventDefault();
        count++;
        behaviour(count);
    });



    //delete element
    $(document).on('click', '#fdt', function () {
        $('#rem-fdt-' + countf).remove();
        c--
        countf--
    });
    $(document).on('click', '#cdt', function () {
        $('#rem-cdt-' + countc).remove();
        c--
        countc--
    });
    $(document).on('click', '#pdt', function () {
        $('#rem-pdt-' + countp).remove();
        c--
        countp--
    });
    $(document).on('click', '#tdt', function () {
        $('#rem-tdt-' + countt).remove();
        c--
        countt--
    });
    $(document).on('click', '#bdt', function () {
        $('#rem-bdt-' + count).remove();
        c--
        count--
    });

});
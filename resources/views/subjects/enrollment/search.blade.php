<table class="table">
    {!! Form::open(['url' => 'subject-sections/enrollment']) !!}   
    <tr>
        <th>Section</th>
        <th>Subject</th>
        <td></td>
    </tr>
    <tr>
        <td>
            <select name="section" id="section_ddl" onchange="configureSubjectDropDownLists()" class="form-control" required>
                <option value="" disabled selected>Select from the following...</option>
                @foreach ($sections as $key => $name)
                    <option value="{{ $key }}">{{ $name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="subject" id="subject_ddl" class="form-control">
                <option value="" disabled selected>Select from the following...</option>
            </select>
        </td>
        <td>
            <button type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-search"></span> Search
            </button>
        </td>
    </tr>
    {!! Form::close() !!}
</table>
<script type="text/javascript">
    function configureSubjectDropDownLists() {
        ddl1 = document.getElementById('section_ddl');
        ddl2 = document.getElementById('subject_ddl');

        switch (ddl1.value) {
            <?php 
            foreach ($sections as $key => $section){
                echo "case '" . $key . "': " .
                        "ddl2.options.length = 0; ".
                        "var opt0 = document.createElement('option'); " .
                        "opt0.value = ''; " . 
                        "opt0.text = 'Select from the following...'; " .
                        "ddl2.options.add(opt0); ";
                foreach ($subjects[$key] as $subject){
                echo    "var opt = document.createElement('option'); " .
                        "opt.value = '" . $subject->id . "'; " .
                        "opt.text = '" . $subject->subject_title . "'; " .
                        "ddl2.options.add(opt);";
                }
                echo    "break;";
            }
            ?>
            default:
                ddl2.options.length = 0;
        }
    }
</script>
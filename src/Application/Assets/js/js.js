$(document).ready(
  function ()
  {
    $('table.table').DataTable(
      {
        paging:  false,
        "info":  false,
        bFilter: false,
        bInfo:   false
      }
    );
  }
);

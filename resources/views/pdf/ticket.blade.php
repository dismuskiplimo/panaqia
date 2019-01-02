<!DOCTYPE html>
<html>
<head>
	<title>{{ $event_request->event->name  }}</title>
	<meta charset="utf-8">
		
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<style>
		body{
			font-family: 'sans-serif';
		}

		.page-break {
		    page-break-after: always;
		}	

		.circle-img{
			border-radius: 50% !important;
		}

		.custom-card{
		  border: 2px solid #e1e1e1;
		  background-color: #ffffff;
		  width: 100%;
		  box-sizing: border-box;
		  float: left;
		}
		.card-inner{
		  background-color: #ffffff;
		  padding: 20px;
		  float: left;
		  width: 100%;
		  box-sizing: border-box;
		}

		.text-center{
			text-align: center;
		}

		.pt-20{
			padding-top: 20px;
		}

		.pt-50{
			padding-top: 50px;
		}

		.size-30{
			width: 30px;
			height: auto;
		}

		.size-40{
			width: 40px;
			height: auto;
		}

		.size-50{
			width: 50px;
			height: auto;
		}

		.size-60{
			width: 60px;
			height: auto;
		}

		.size-70{
			width: 70px;
			height: auto;
		}

		.size-100{
			width: 100px;
			height: auto;
		}

		.size-200{
			width: 200px;
			height: auto;
		}

		.container {
  padding-right: 15px;
  padding-left: 15px;
  margin-right: auto;
  margin-left: auto;
}
@media (min-width: 768px) {
  .container {
    width: 750px;
  }
}
@media (min-width: 992px) {
  .container {
    width: 970px;
  }
}
@media (min-width: 1200px) {
  .container {
    width: 1170px;
  }
}
.container-fluid {
  padding-right: 15px;
  padding-left: 15px;
  margin-right: auto;
  margin-left: auto;
}
.row {
  margin-right: -15px;
  margin-left: -15px;
}
.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
  position: relative;
  min-height: 1px;
  padding-right: 15px;
  padding-left: 15px;
}
.col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
  float: left;
}
.col-xs-12 {
  width: 100%;
}
.col-xs-11 {
  width: 91.66666667%;
}
.col-xs-10 {
  width: 83.33333333%;
}
.col-xs-9 {
  width: 75%;
}
.col-xs-8 {
  width: 66.66666667%;
}
.col-xs-7 {
  width: 58.33333333%;
}
.col-xs-6 {
  width: 50%;
}
.col-xs-5 {
  width: 41.66666667%;
}
.col-xs-4 {
  width: 33.33333333%;
}
.col-xs-3 {
  width: 25%;
}
.col-xs-2 {
  width: 16.66666667%;
}
.col-xs-1 {
  width: 8.33333333%;
}
.col-xs-pull-12 {
  right: 100%;
}
.col-xs-pull-11 {
  right: 91.66666667%;
}
.col-xs-pull-10 {
  right: 83.33333333%;
}
.col-xs-pull-9 {
  right: 75%;
}
.col-xs-pull-8 {
  right: 66.66666667%;
}
.col-xs-pull-7 {
  right: 58.33333333%;
}
.col-xs-pull-6 {
  right: 50%;
}
.col-xs-pull-5 {
  right: 41.66666667%;
}
.col-xs-pull-4 {
  right: 33.33333333%;
}
.col-xs-pull-3 {
  right: 25%;
}
.col-xs-pull-2 {
  right: 16.66666667%;
}
.col-xs-pull-1 {
  right: 8.33333333%;
}
.col-xs-pull-0 {
  right: auto;
}
.col-xs-push-12 {
  left: 100%;
}
.col-xs-push-11 {
  left: 91.66666667%;
}
.col-xs-push-10 {
  left: 83.33333333%;
}
.col-xs-push-9 {
  left: 75%;
}
.col-xs-push-8 {
  left: 66.66666667%;
}
.col-xs-push-7 {
  left: 58.33333333%;
}
.col-xs-push-6 {
  left: 50%;
}
.col-xs-push-5 {
  left: 41.66666667%;
}
.col-xs-push-4 {
  left: 33.33333333%;
}
.col-xs-push-3 {
  left: 25%;
}
.col-xs-push-2 {
  left: 16.66666667%;
}
.col-xs-push-1 {
  left: 8.33333333%;
}
.col-xs-push-0 {
  left: auto;
}
.col-xs-offset-12 {
  margin-left: 100%;
}
.col-xs-offset-11 {
  margin-left: 91.66666667%;
}
.col-xs-offset-10 {
  margin-left: 83.33333333%;
}
.col-xs-offset-9 {
  margin-left: 75%;
}
.col-xs-offset-8 {
  margin-left: 66.66666667%;
}
.col-xs-offset-7 {
  margin-left: 58.33333333%;
}
.col-xs-offset-6 {
  margin-left: 50%;
}
.col-xs-offset-5 {
  margin-left: 41.66666667%;
}
.col-xs-offset-4 {
  margin-left: 33.33333333%;
}
.col-xs-offset-3 {
  margin-left: 25%;
}
.col-xs-offset-2 {
  margin-left: 16.66666667%;
}
.col-xs-offset-1 {
  margin-left: 8.33333333%;
}
.col-xs-offset-0 {
  margin-left: 0;
}
@media (min-width: 768px) {
  .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
    float: left;
  }
  .col-sm-12 {
    width: 100%;
  }
  .col-sm-11 {
    width: 91.66666667%;
  }
  .col-sm-10 {
    width: 83.33333333%;
  }
  .col-sm-9 {
    width: 75%;
  }
  .col-sm-8 {
    width: 66.66666667%;
  }
  .col-sm-7 {
    width: 58.33333333%;
  }
  .col-sm-6 {
    width: 50%;
  }
  .col-sm-5 {
    width: 41.66666667%;
  }
  .col-sm-4 {
    width: 33.33333333%;
  }
  .col-sm-3 {
    width: 25%;
  }
  .col-sm-2 {
    width: 16.66666667%;
  }
  .col-sm-1 {
    width: 8.33333333%;
  }
  .col-sm-pull-12 {
    right: 100%;
  }
  .col-sm-pull-11 {
    right: 91.66666667%;
  }
  .col-sm-pull-10 {
    right: 83.33333333%;
  }
  .col-sm-pull-9 {
    right: 75%;
  }
  .col-sm-pull-8 {
    right: 66.66666667%;
  }
  .col-sm-pull-7 {
    right: 58.33333333%;
  }
  .col-sm-pull-6 {
    right: 50%;
  }
  .col-sm-pull-5 {
    right: 41.66666667%;
  }
  .col-sm-pull-4 {
    right: 33.33333333%;
  }
  .col-sm-pull-3 {
    right: 25%;
  }
  .col-sm-pull-2 {
    right: 16.66666667%;
  }
  .col-sm-pull-1 {
    right: 8.33333333%;
  }
  .col-sm-pull-0 {
    right: auto;
  }
  .col-sm-push-12 {
    left: 100%;
  }
  .col-sm-push-11 {
    left: 91.66666667%;
  }
  .col-sm-push-10 {
    left: 83.33333333%;
  }
  .col-sm-push-9 {
    left: 75%;
  }
  .col-sm-push-8 {
    left: 66.66666667%;
  }
  .col-sm-push-7 {
    left: 58.33333333%;
  }
  .col-sm-push-6 {
    left: 50%;
  }
  .col-sm-push-5 {
    left: 41.66666667%;
  }
  .col-sm-push-4 {
    left: 33.33333333%;
  }
  .col-sm-push-3 {
    left: 25%;
  }
  .col-sm-push-2 {
    left: 16.66666667%;
  }
  .col-sm-push-1 {
    left: 8.33333333%;
  }
  .col-sm-push-0 {
    left: auto;
  }
  .col-sm-offset-12 {
    margin-left: 100%;
  }
  .col-sm-offset-11 {
    margin-left: 91.66666667%;
  }
  .col-sm-offset-10 {
    margin-left: 83.33333333%;
  }
  .col-sm-offset-9 {
    margin-left: 75%;
  }
  .col-sm-offset-8 {
    margin-left: 66.66666667%;
  }
  .col-sm-offset-7 {
    margin-left: 58.33333333%;
  }
  .col-sm-offset-6 {
    margin-left: 50%;
  }
  .col-sm-offset-5 {
    margin-left: 41.66666667%;
  }
  .col-sm-offset-4 {
    margin-left: 33.33333333%;
  }
  .col-sm-offset-3 {
    margin-left: 25%;
  }
  .col-sm-offset-2 {
    margin-left: 16.66666667%;
  }
  .col-sm-offset-1 {
    margin-left: 8.33333333%;
  }
  .col-sm-offset-0 {
    margin-left: 0;
  }
}
@media (min-width: 992px) {
  .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
    float: left;
  }
  .col-md-12 {
    width: 100%;
  }
  .col-md-11 {
    width: 91.66666667%;
  }
  .col-md-10 {
    width: 83.33333333%;
  }
  .col-md-9 {
    width: 75%;
  }
  .col-md-8 {
    width: 66.66666667%;
  }
  .col-md-7 {
    width: 58.33333333%;
  }
  .col-md-6 {
    width: 50%;
  }
  .col-md-5 {
    width: 41.66666667%;
  }
  .col-md-4 {
    width: 33.33333333%;
  }
  .col-md-3 {
    width: 25%;
  }
  .col-md-2 {
    width: 16.66666667%;
  }
  .col-md-1 {
    width: 8.33333333%;
  }
  .col-md-pull-12 {
    right: 100%;
  }
  .col-md-pull-11 {
    right: 91.66666667%;
  }
  .col-md-pull-10 {
    right: 83.33333333%;
  }
  .col-md-pull-9 {
    right: 75%;
  }
  .col-md-pull-8 {
    right: 66.66666667%;
  }
  .col-md-pull-7 {
    right: 58.33333333%;
  }
  .col-md-pull-6 {
    right: 50%;
  }
  .col-md-pull-5 {
    right: 41.66666667%;
  }
  .col-md-pull-4 {
    right: 33.33333333%;
  }
  .col-md-pull-3 {
    right: 25%;
  }
  .col-md-pull-2 {
    right: 16.66666667%;
  }
  .col-md-pull-1 {
    right: 8.33333333%;
  }
  .col-md-pull-0 {
    right: auto;
  }
  .col-md-push-12 {
    left: 100%;
  }
  .col-md-push-11 {
    left: 91.66666667%;
  }
  .col-md-push-10 {
    left: 83.33333333%;
  }
  .col-md-push-9 {
    left: 75%;
  }
  .col-md-push-8 {
    left: 66.66666667%;
  }
  .col-md-push-7 {
    left: 58.33333333%;
  }
  .col-md-push-6 {
    left: 50%;
  }
  .col-md-push-5 {
    left: 41.66666667%;
  }
  .col-md-push-4 {
    left: 33.33333333%;
  }
  .col-md-push-3 {
    left: 25%;
  }
  .col-md-push-2 {
    left: 16.66666667%;
  }
  .col-md-push-1 {
    left: 8.33333333%;
  }
  .col-md-push-0 {
    left: auto;
  }
  .col-md-offset-12 {
    margin-left: 100%;
  }
  .col-md-offset-11 {
    margin-left: 91.66666667%;
  }
  .col-md-offset-10 {
    margin-left: 83.33333333%;
  }
  .col-md-offset-9 {
    margin-left: 75%;
  }
  .col-md-offset-8 {
    margin-left: 66.66666667%;
  }
  .col-md-offset-7 {
    margin-left: 58.33333333%;
  }
  .col-md-offset-6 {
    margin-left: 50%;
  }
  .col-md-offset-5 {
    margin-left: 41.66666667%;
  }
  .col-md-offset-4 {
    margin-left: 33.33333333%;
  }
  .col-md-offset-3 {
    margin-left: 25%;
  }
  .col-md-offset-2 {
    margin-left: 16.66666667%;
  }
  .col-md-offset-1 {
    margin-left: 8.33333333%;
  }
  .col-md-offset-0 {
    margin-left: 0;
  }
}
@media (min-width: 1200px) {
  .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12 {
    float: left;
  }
  .col-lg-12 {
    width: 100%;
  }
  .col-lg-11 {
    width: 91.66666667%;
  }
  .col-lg-10 {
    width: 83.33333333%;
  }
  .col-lg-9 {
    width: 75%;
  }
  .col-lg-8 {
    width: 66.66666667%;
  }
  .col-lg-7 {
    width: 58.33333333%;
  }
  .col-lg-6 {
    width: 50%;
  }
  .col-lg-5 {
    width: 41.66666667%;
  }
  .col-lg-4 {
    width: 33.33333333%;
  }
  .col-lg-3 {
    width: 25%;
  }
  .col-lg-2 {
    width: 16.66666667%;
  }
  .col-lg-1 {
    width: 8.33333333%;
  }
  .col-lg-pull-12 {
    right: 100%;
  }
  .col-lg-pull-11 {
    right: 91.66666667%;
  }
  .col-lg-pull-10 {
    right: 83.33333333%;
  }
  .col-lg-pull-9 {
    right: 75%;
  }
  .col-lg-pull-8 {
    right: 66.66666667%;
  }
  .col-lg-pull-7 {
    right: 58.33333333%;
  }
  .col-lg-pull-6 {
    right: 50%;
  }
  .col-lg-pull-5 {
    right: 41.66666667%;
  }
  .col-lg-pull-4 {
    right: 33.33333333%;
  }
  .col-lg-pull-3 {
    right: 25%;
  }
  .col-lg-pull-2 {
    right: 16.66666667%;
  }
  .col-lg-pull-1 {
    right: 8.33333333%;
  }
  .col-lg-pull-0 {
    right: auto;
  }
  .col-lg-push-12 {
    left: 100%;
  }
  .col-lg-push-11 {
    left: 91.66666667%;
  }
  .col-lg-push-10 {
    left: 83.33333333%;
  }
  .col-lg-push-9 {
    left: 75%;
  }
  .col-lg-push-8 {
    left: 66.66666667%;
  }
  .col-lg-push-7 {
    left: 58.33333333%;
  }
  .col-lg-push-6 {
    left: 50%;
  }
  .col-lg-push-5 {
    left: 41.66666667%;
  }
  .col-lg-push-4 {
    left: 33.33333333%;
  }
  .col-lg-push-3 {
    left: 25%;
  }
  .col-lg-push-2 {
    left: 16.66666667%;
  }
  .col-lg-push-1 {
    left: 8.33333333%;
  }
  .col-lg-push-0 {
    left: auto;
  }
  .col-lg-offset-12 {
    margin-left: 100%;
  }
  .col-lg-offset-11 {
    margin-left: 91.66666667%;
  }
  .col-lg-offset-10 {
    margin-left: 83.33333333%;
  }
  .col-lg-offset-9 {
    margin-left: 75%;
  }
  .col-lg-offset-8 {
    margin-left: 66.66666667%;
  }
  .col-lg-offset-7 {
    margin-left: 58.33333333%;
  }
  .col-lg-offset-6 {
    margin-left: 50%;
  }
  .col-lg-offset-5 {
    margin-left: 41.66666667%;
  }
  .col-lg-offset-4 {
    margin-left: 33.33333333%;
  }
  .col-lg-offset-3 {
    margin-left: 25%;
  }
  .col-lg-offset-2 {
    margin-left: 16.66666667%;
  }
  .col-lg-offset-1 {
    margin-left: 8.33333333%;
  }
  .col-lg-offset-0 {
    margin-left: 0;
  }
}

		.table {
			border-collapse: collapse !important;
		}

		.table td,
		.table th {
			background-color: #fff !important;
		}

		.table-bordered th,
		.table-bordered td {
			border: 1px solid #ddd !important;
		}

		table {
		  background-color: transparent;
		}
		caption {
		  padding-top: 8px;
		  padding-bottom: 8px;
		  color: #777;
		  text-align: left;
		}
		th {
		  text-align: left;
		}
		.table {
		  width: 100%;
		  max-width: 100%;
		  margin-bottom: 20px;
		}
		.table > thead > tr > th,
		.table > tbody > tr > th,
		.table > tfoot > tr > th,
		.table > thead > tr > td,
		.table > tbody > tr > td,
		.table > tfoot > tr > td {
		  padding: 8px;
		  line-height: 1.42857143;
		  vertical-align: top;
		  border-top: 1px solid #ddd;
		}
		.table > thead > tr > th {
		  vertical-align: bottom;
		  border-bottom: 2px solid #ddd;
		}
		.table > caption + thead > tr:first-child > th,
		.table > colgroup + thead > tr:first-child > th,
		.table > thead:first-child > tr:first-child > th,
		.table > caption + thead > tr:first-child > td,
		.table > colgroup + thead > tr:first-child > td,
		.table > thead:first-child > tr:first-child > td {
		  border-top: 0;
		}
		.table > tbody + tbody {
		  border-top: 2px solid #ddd;
		}
		.table .table {
		  background-color: #fff;
		}
		.table-condensed > thead > tr > th,
		.table-condensed > tbody > tr > th,
		.table-condensed > tfoot > tr > th,
		.table-condensed > thead > tr > td,
		.table-condensed > tbody > tr > td,
		.table-condensed > tfoot > tr > td {
		  padding: 5px;
		}
		.table-bordered {
		  border: 1px solid #ddd;
		}
		.table-bordered > thead > tr > th,
		.table-bordered > tbody > tr > th,
		.table-bordered > tfoot > tr > th,
		.table-bordered > thead > tr > td,
		.table-bordered > tbody > tr > td,
		.table-bordered > tfoot > tr > td {
		  border: 1px solid #ddd;
		}
		.table-bordered > thead > tr > th,
		.table-bordered > thead > tr > td {
		  border-bottom-width: 2px;
		}
		.table-striped > tbody > tr:nth-of-type(odd) {
		  background-color: #f9f9f9;
		}
		.table-hover > tbody > tr:hover {
		  background-color: #f5f5f5;
		}
		table col[class*="col-"] {
		  position: static;
		  display: table-column;
		  float: none;
		}
		table td[class*="col-"],
		table th[class*="col-"] {
		  position: static;
		  display: table-cell;
		  float: none;
		}
		.table > thead > tr > td.active,
		.table > tbody > tr > td.active,
		.table > tfoot > tr > td.active,
		.table > thead > tr > th.active,
		.table > tbody > tr > th.active,
		.table > tfoot > tr > th.active,
		.table > thead > tr.active > td,
		.table > tbody > tr.active > td,
		.table > tfoot > tr.active > td,
		.table > thead > tr.active > th,
		.table > tbody > tr.active > th,
		.table > tfoot > tr.active > th {
		  background-color: #f5f5f5;
		}
		.table-hover > tbody > tr > td.active:hover,
		.table-hover > tbody > tr > th.active:hover,
		.table-hover > tbody > tr.active:hover > td,
		.table-hover > tbody > tr:hover > .active,
		.table-hover > tbody > tr.active:hover > th {
		  background-color: #e8e8e8;
		}
		.table > thead > tr > td.success,
		.table > tbody > tr > td.success,
		.table > tfoot > tr > td.success,
		.table > thead > tr > th.success,
		.table > tbody > tr > th.success,
		.table > tfoot > tr > th.success,
		.table > thead > tr.success > td,
		.table > tbody > tr.success > td,
		.table > tfoot > tr.success > td,
		.table > thead > tr.success > th,
		.table > tbody > tr.success > th,
		.table > tfoot > tr.success > th {
		  background-color: #dff0d8;
		}
		.table-hover > tbody > tr > td.success:hover,
		.table-hover > tbody > tr > th.success:hover,
		.table-hover > tbody > tr.success:hover > td,
		.table-hover > tbody > tr:hover > .success,
		.table-hover > tbody > tr.success:hover > th {
		  background-color: #d0e9c6;
		}
		.table > thead > tr > td.info,
		.table > tbody > tr > td.info,
		.table > tfoot > tr > td.info,
		.table > thead > tr > th.info,
		.table > tbody > tr > th.info,
		.table > tfoot > tr > th.info,
		.table > thead > tr.info > td,
		.table > tbody > tr.info > td,
		.table > tfoot > tr.info > td,
		.table > thead > tr.info > th,
		.table > tbody > tr.info > th,
		.table > tfoot > tr.info > th {
		  background-color: #d9edf7;
		}
		.table-hover > tbody > tr > td.info:hover,
		.table-hover > tbody > tr > th.info:hover,
		.table-hover > tbody > tr.info:hover > td,
		.table-hover > tbody > tr:hover > .info,
		.table-hover > tbody > tr.info:hover > th {
		  background-color: #c4e3f3;
		}
		.table > thead > tr > td.warning,
		.table > tbody > tr > td.warning,
		.table > tfoot > tr > td.warning,
		.table > thead > tr > th.warning,
		.table > tbody > tr > th.warning,
		.table > tfoot > tr > th.warning,
		.table > thead > tr.warning > td,
		.table > tbody > tr.warning > td,
		.table > tfoot > tr.warning > td,
		.table > thead > tr.warning > th,
		.table > tbody > tr.warning > th,
		.table > tfoot > tr.warning > th {
		  background-color: #fcf8e3;
		}
		.table-hover > tbody > tr > td.warning:hover,
		.table-hover > tbody > tr > th.warning:hover,
		.table-hover > tbody > tr.warning:hover > td,
		.table-hover > tbody > tr:hover > .warning,
		.table-hover > tbody > tr.warning:hover > th {
		  background-color: #faf2cc;
		}
		.table > thead > tr > td.danger,
		.table > tbody > tr > td.danger,
		.table > tfoot > tr > td.danger,
		.table > thead > tr > th.danger,
		.table > tbody > tr > th.danger,
		.table > tfoot > tr > th.danger,
		.table > thead > tr.danger > td,
		.table > tbody > tr.danger > td,
		.table > tfoot > tr.danger > td,
		.table > thead > tr.danger > th,
		.table > tbody > tr.danger > th,
		.table > tfoot > tr.danger > th {
		  background-color: #f2dede;
		}
		.table-hover > tbody > tr > td.danger:hover,
		.table-hover > tbody > tr > th.danger:hover,
		.table-hover > tbody > tr.danger:hover > td,
		.table-hover > tbody > tr:hover > .danger,
		.table-hover > tbody > tr.danger:hover > th {
		  background-color: #ebcccc;
		}
		.table-responsive {
		  min-height: .01%;
		  overflow-x: auto;
		}
		@media screen and (max-width: 767px) {
		  .table-responsive {
		    width: 100%;
		    margin-bottom: 15px;
		    overflow-y: hidden;
		    -ms-overflow-style: -ms-autohiding-scrollbar;
		    border: 1px solid #ddd;
		  }
		  .table-responsive > .table {
		    margin-bottom: 0;
		  }
		  .table-responsive > .table > thead > tr > th,
		  .table-responsive > .table > tbody > tr > th,
		  .table-responsive > .table > tfoot > tr > th,
		  .table-responsive > .table > thead > tr > td,
		  .table-responsive > .table > tbody > tr > td,
		  .table-responsive > .table > tfoot > tr > td {
		    white-space: nowrap;
		  }
		  .table-responsive > .table-bordered {
		    border: 0;
		  }
		  .table-responsive > .table-bordered > thead > tr > th:first-child,
		  .table-responsive > .table-bordered > tbody > tr > th:first-child,
		  .table-responsive > .table-bordered > tfoot > tr > th:first-child,
		  .table-responsive > .table-bordered > thead > tr > td:first-child,
		  .table-responsive > .table-bordered > tbody > tr > td:first-child,
		  .table-responsive > .table-bordered > tfoot > tr > td:first-child {
		    border-left: 0;
		  }
		  .table-responsive > .table-bordered > thead > tr > th:last-child,
		  .table-responsive > .table-bordered > tbody > tr > th:last-child,
		  .table-responsive > .table-bordered > tfoot > tr > th:last-child,
		  .table-responsive > .table-bordered > thead > tr > td:last-child,
		  .table-responsive > .table-bordered > tbody > tr > td:last-child,
		  .table-responsive > .table-bordered > tfoot > tr > td:last-child {
		    border-right: 0;
		  }
		  .table-responsive > .table-bordered > tbody > tr:last-child > th,
		  .table-responsive > .table-bordered > tfoot > tr:last-child > th,
		  .table-responsive > .table-bordered > tbody > tr:last-child > td,
		  .table-responsive > .table-bordered > tfoot > tr:last-child > td {
		    border-bottom: 0;
		  }
		}



	</style>
</head>
<body>
	<div class="container  pt-50">
		<p class="text-center">
			<img src="{{ $logo }}" alt="" class="size-100">
			
		</p>

		<h3 class="text-center">{{ strtoupper(config('app.name')) }}</h3><br>

		<hr>

		<br>

		<h2 class="text-center">EVENT TICKET</h2><br>

		
		
		<div class="row">
			<div class="col-xs-3 text-center">
				<img src="{{ $pic  }}" alt="" class="size-200 circle-img" >

				

				
			</div>

			<div class="col-xs-8">
				
				<table class="">
					<tr>
						<th>EVENT</th>
						<td>{{ $event_request->event->name }}</td>
					</tr>

					<tr>
						<th>NAME</th>
						<td>{{ $event_request->user->name }}</td>
					</tr>

					<tr>
						<th>ATTENDING AS</th>
						<td>
							@if($event_request->attending_as == 'SPEAKER')
								SPEAKER
							@elseif($event_request->attending_as == 'DELEGATE')
								DELEGATE/ATTENDEE
							@elseif($event_request->attending_as == 'EXHIBITOR')
								SHOWCASER/EXHIBITOR
							@endif
						</td>
					</tr>

					<tr>
						<th>DATE</th>
						<td>
							{{ defaultDate($event_request->event->start_date) == defaultDate($event_request->event->end_date) ? niceDate($event_request->event->start_date) : niceDate($event_request->event->start_date) . ' - ' . niceDate($event_request->event->end_date) }} 

                        	{{ ' (' . $event_request->event->start_time .' - '. $event_request->event->end_time . ')' }}
						</td>
					</tr>

					<tr>
						<th>AMOUNT PAID</th>
						<td>{{ $event_request->currency_code }} {{ number_format($event_request->amount_paid,2) }}</td>
					</tr>

					<tr>
						<th></th>
						<td></td>
					</tr>
				</table>
	
				<h3>TICKET CODE : <strong>{{ $event_request->code }}</strong> </h3>
			</div>
				
		</div>

		
	</div>
</body>
</html>
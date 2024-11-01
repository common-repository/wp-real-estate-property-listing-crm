<style type="text/css">
.mwp-current-view-map{
	padding-top:150px;
}
#main>.row {
    overflow-y:scroll;
}
.mwp-map-container{
	top:150px;
}
#map-canvas {
    height:calc(100% - 0);
    position:absolute;
    right:16px;
    bottom:0;
    overflow:hidden;
}
#veil {
	position: absolute;
	top: 0;
	left: 0;
	height:100%;
	width:100%;
	cursor: not-allowed;
	filter: alpha(opacity=60);
	opacity: 0.6;
	background: #000000 no-repeat center;
}
#feedLoading {
	position: absolute;
	top:200px;
	width:100%;
	text-align: center;
	font-size: 4em;
	color:white;
	text-shadow: 2px 2px 2px #021124;
}
/*mobile*/
@media only screen and (min-width : 768px) {
	.mwp-current-view-map .navbar-fixed-top{
		position:fixed;
	}
	.mwp-search-result-page .mwp-map-container{
		top:150px;
	}
}
/*non mobile*/
@media only screen and (max-width : 768px) {
	.mwp-current-view-map .navbar-fixed-top{
		position:fixed;
	}
	.mwp-search-result-page .mwp-map-container{
		top:50px;
	}
}
@media only screen and (min-width : 992px) {
	.mwp-current-view-map .navbar-fixed-top{
		position:fixed;
	}
}
@media only screen and (max-width : 992px) {

}
</style>

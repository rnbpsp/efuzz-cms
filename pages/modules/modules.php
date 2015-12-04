<html>
	<head>
		<title>Modules</title>
		<style>
			#bkg {
			
				width:100%;
				margin:0;
			}
			nav { position:absolute;
				top:40%;
				left:10%;
				width:25%;
				height:800px;
				overflow-y:auto;
				}
			@keyframes video_fadeIn
			{
				0% {opacity:0;}
				100% {opacity:1;}
			}
			#video {
				display:none;
				position: absolute;
				top:55%;
				right:10%;
				width:40%;
				height:500px;
				border: 3px solid white;
				box-shadow : 15px 30px 70px 30px black;
				opacity: 0;
				}
			#shad {
				display:none;
				position: fixed;
				top:0;
				right:0%;
				width:65%;
				height:100%;
				background-color: white;
				opacity: 0.3;
				}
			
		</style>
				<!--script type="text/javascript" src="/min/b=efuzz/jslib&amp;f=jquery-1.11.3.min.js,jquery.ba-hashchange.min.js"></!--script-->
        <script type="text/javascript" src="scripts/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="scripts/jquery.ba-hashchange.min.js"></script>
	</head>
	<body>
			<img id="bkg" src="styles/content/bak2.png">
		<nav>
			<a href="#">Lessons</a>
			<br><br>Prelim
		<ul>
			1. Introduction of Discrete Mathematics
			<ul>
			<li> <a href ="#ppt=https://docs.google.com/presentation/d/1wNYU_6uIh6td3oTrjCG6WYm8J_SE7iiO_-YIfZYfIhQ/embed?start=true&loop=true&delayms=3000"> Propositional and Logical connectives</a></li>
			<li> <a href ="#ppt=https://docs.google.com/presentation/d/1sBLjg0Fcjaq4zA_37NBP5JdWMS9J05MubUyqcAmodrs/embed?start=true&loop=true&delayms=3000"> Sets and Venn Diagram </a></li>
			<li> <a href ="#youtube=vlDeWoc993w">Quiz</a></li>
			<li> <a href ="#q">Exam</a></li>
			</ul>
		</ul>
		<br><br>Midterm
		<ul>
			2. Rational Expressions
			<ul>
			<li><a href ="#q"> Rules of Exponents; Simplification of Rational Expressions; Operations on Rational Expressions</a></li>
			<li><a href ="#q"> Properties of Radicals; Simplification of Radicals</a></li>
			<li><a href ="#q"> Quiz</a></li>
			<li><a href ="#q"> Exam</a></li>
			</ul>
		</ul>
		<br><br>Finals
		<ul>
			3. GRAPHS
			<ul>
			<li><a href ="#ppt=https://docs.google.com/presentation/d/12zFh1XmsiWfBS9kvsNmJBlm5gCUv6zvnlUGGpylPfGA/embed?start=true&loop=true&delayms=3000"> Graph, complete Graph, Biparte and combining Graph</a></li>
			<li><a href ="#q"> quiz</a></li>
			<li><a href ="#q"> exam</a></li>
			</ul>
		</ul>
		
		</nav>
		<div id="shad"></div>
		<div id="video"><iframe id="frame" width="100%" height="100%" src="" frameborder="0" allowfullscreen></iframe></div>
			<script type="text/javascript" src="pages/modules/script.js"></script>
	</body>
</html>
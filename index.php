<!DOCTYPE html>
<html>
<head>
<title>C4E Visualization</title>
<meta charset="utf-8">
<meta name="author" content="Keyuan Zhou">
<style>
div.pos_left{
    font: 350 15px "Helvetica Neue", Helvetica, Arial, sans-serif;
    position:fixed;
    left:1000px;
    top: 250px;

}
.link {
    stroke: #cccccc;
    stroke-opacity: 0;
/*    fill: none;*/
    fill: #5d5d5d;
    fill-opacity: 0.05;
    pointer-events: none;
}

.link1 {
    /*fill: #da4c31;*/
    fill: #3E8E64;
    fill-opacity: 0.15;
    }

.link2 {
    /*fill: #287a4d;*/
    fill: #045C2E;
    fill-opacity: 0.15;
}

.link3 {
    /*fill: #315ea2;*/
    fill: #04345D;
    fill-opacity: 0.15;
}

.node_hover {
    opacity: 0.25;
}

.text_hover {
    opacity: 0.25;
}

text {
    font: 350 15px "Helvetica Neue", Helvetica, Arial, sans-serif;
}

.text1, .text2, .text3 {
    font-size: 18px;
    font-weight: 700;
    }

.line1 {
    stroke: #3E8E64; /* PI - red */
    stroke-width: 2;
    stroke-opacity: 1;
    }

.line2 {
    stroke: #045C2E; /* Action - green */
    stroke-width: 2;
    stroke-opacity: 1;
}

.line3 {
    stroke: #04345D; /* Sample - blue */
    stroke-width: 2;
    stroke-opacity: 1;
}



</style>
</head>

<body>

<div class = "pos_left">
<p style="font-size: 25px" id = "title">Title</p>
<p style="font-size: 20px">Introduction</p>
<p style = "width: 600px" id = "content"></p>
<p style="font-size: 20px">Outcome</p>
<p id = "outcome1"></p>
<p id = "outcome2"></p>
<p id = "outcome3"></p>
<p id = "outcome4"></p>
<p style="font-size: 20px">Link</p>
<a href="https://va.tech.purdue.edu/c4e/" id="link"></a>


</div>


<script src="https://d3js.org/d3.v4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

var diameter = 960,
    radius = diameter / 2,
    innerRadius = radius - 180;
var Hoverednumber = 0;
var Judge = false;
var div = document.getElementById("title");
var div1 = document.getElementById("content");
var div2 = document.getElementById("outcome1");
var div3 = document.getElementById("outcome2");
var div4 = document.getElementById("outcome3");
var div5 = document.getElementById("outcome4");
var div6 = document.getElementById("link");

var svg = d3.select("body").append("svg")
            .attr("width", diameter)
            .attr("height", diameter)
            .append("g")
            .attr("transform", "translate(" + radius + "," + radius + ")");

var line = d3.radialLine()
             .curve(d3.curveBundle.beta(0.85))
             .radius(innerRadius)
             .angle(function(d) { return d / data_count * Math.PI * 2; });


var node = svg.append("g");
    text = svg.append("g");
    link = svg.append("g").attr("class", "path");

var color11 = "#045C2E"; // PI - green
    color1 = "#3E8E64";
    // color22 = "#04045C"; // Action - purple
    // color2 = "#52528C";
    color22 = "#7F2628"; // Action - purple
    color2 = "#BF272E";
    color33 = "#043866"; // Sample - blue
    color3 = "#387DB4";


d3.json("data/data6.json", function(error, json){

    var data_count = json.length;
    let circle_radius = innerRadius;
    let text_radius = innerRadius;
    let position = -11;

    node = node.selectAll("circle")
               .data(json)
               .enter().append("circle")
               .attr("transform", function(i, d) { let angle = (d + position) / data_count * 2 * Math.PI;
                                                   return "translate(" + circle_radius * Math.cos(angle) + "," + circle_radius * Math.sin(angle) + ")"; })
               .attr("cx", 0)
               .attr("cy", 0)
               .attr("r", 8)
               .attr("fill", function(i, d) { if (i.size == 1) { return color1; }
                                              else if (i.size == 2) { return color2; }
                                              else if (i.size == 3) { return color3; }
                                              else { return "white"; } })
               .attr("opacity", function(i, d) { if (i.size < 10) { return 1; }
                                                 else { return 0; } })
               .attr("class", function(i, d) { return "node n" + (d+1) });

    text = text.selectAll("text")
               .data(json)
               .enter().append("text")
               .text(function(i, d) { return i.name; })
               .attr("transform", function(i, d) { let angle = (d + position) / data_count * 360;
                                                   if (90 < angle && angle <= 270) { return "rotate(" + angle + ",0,0)translate(320, -6)rotate(180,0,0)"; }
                                                   else { return "rotate(" + angle + ",0,0)translate(320, 6)"; }
                                                    })
               .attr("text-anchor", function(i, d) { let angle = (d + position) / data_count * 360;
                                                     if (90 < angle && angle <= 270) { return "end"; }
                                                     else { return "start"; } })
               .attr("opacity", function(i, d) { if (i.size < 10) { return 1; }
                                                 else { return 0; } })
               .attr("fill", function(i, d) { if (i.size == 1) { return color1 }
                                               else if (i.size == 2) { return color2 }
                                               else if (i.size == 3) { return color3 }
                                               else { return "white" }
                                             })
               .attr("class", function(i, d) { return "font t" + (d+1) })
               .on("mouseover", mouseovered)
               .on("mouseout", mouseouted)
               .on("click",mousedown);




    function mouseovered(d) {
     //    text.

        // text.classed("text1", function(l){ if (l === d && d.size === 1) return true; })
        //  .classed("text2", function(l){ if (l === d && d.size === 2) return true; })
        //  .classed("text3", function(l){ if (l === d && d.size === 3) return true; });

        Hoverednumber = d.number;
        // console.log(Hoverednumber);


        // d3.selectAll(".node").classed("node_hover", true);
        // d3.selectAll(".font").classed("text_hover", true);
        d3.select(".t"+d.number)
          .transition()
          .style("font-size", "18px")
          .style("font-weight", 700)
          .style("cursor", "pointer");

        if (d.size == 1) {
            // console.log(d3.select(".p"+d.number));
            // d3.selectAll(".p"+d.number).classed("line1", true);
            d3.selectAll(".link")
              .transition()
              .style("fill-opacity", 0);

            d3.selectAll(".p"+d.number)
              .transition()
              .style("fill", color11)
              .style("fill-opacity", 0.15);

        } else if (d.size == 2) {
            // d3.selectAll(".p"+d.number).classed("line2", true);
            d3.selectAll(".link")
              .transition()
              .style("fill-opacity", 0);

            d3.selectAll(".p"+d.number)
              .transition()
              .style("fill", color22)
              .style("fill-opacity", 0.15);
        } else if (d.size == 3) {
            // d3.selectAll(".p"+d.number).classed("line3", true);
            d3.selectAll(".link")
              .transition()
              .style("fill-opacity", 0);

            d3.selectAll(".p"+d.number)
              .transition()
              .style("fill", color33)
              .style("fill-opacity", 0.15);
        } else {}

        // d3.select(".n"+d.number).classed("node_hover", false);
        // d3.select(".t"+d.number).classed("text_hover", false);
        // console.log(".n"+d.number);

    }

    function mouseouted(d) {
        Hoverednumber = d.number;

        // text.classed("text", false)
        //  .classed("text1", false)
        //  .classed("text2", false)
        //  .classed("text3", false);

        d3.selectAll(".p"+d.number)
          .transition()
          .style("fill-opacity", 0);

        d3.selectAll(".t"+d.number)
          .transition()
          .style("font-size", "15px")
          .style("font-weight", 350);

        if (d.size == 1) {
            d3.selectAll(".link")
              .transition()
              .style("fill", color11)
              .style("fill-opacity", 0.075);
        } else if (d.size == 2) {
            d3.selectAll(".link")
              .transition()
              .style("fill", color22)
              .style("fill-opacity", 0.075);
        } else if (d.size == 3) {
            d3.selectAll(".link")
              .transition()
              .style("fill", color33)
              .style("fill-opacity", 0.075);
        } else {}


        // d3.selectAll(".node").classed("node_hover", false);
        // d3.selectAll(".font").classed("text_hover", false);


        Hoverednumber = 0;
    }

    function mousedown(d) {
        text.classed("text4", function(l){if (l === d && l.size !== 10) return true});

      div.textContent = d.title;
      div1.textContent = d.content;
      div2.textContent = d.outcome1;
      div3.textContent = d.outcome2;
      div4.textContent = d.outcome3;
      div5.textContent = d.outcome4;
      div6.textContent = d.link;
    }


});


d3.json("data/data4.json", function(error, json){
    var data_count = 48;
    var radialLineGenerator = d3.radialLine()
                            .curve(d3.curveBundle.beta(0.85));

    var line_radius = innerRadius - 10;


    json.forEach(function(d){

        // console.log(d);

        var points1 = [
        [d.PrincipalInvestigator / data_count * 2 * Math.PI, line_radius],[0,0],[d.Analysis / data_count * 2 * Math.PI, line_radius],
        ];
        var radialLine1 = radialLineGenerator(points1);


        var points2 = [
        [d.Analysis / data_count * 2 * Math.PI, line_radius],[0,0],[d.Sample / data_count * 2 * Math.PI, line_radius],
        ];

        var radialLine2 = radialLineGenerator(points2);


        var points3 = [
        [d.Sample / data_count * 2 * Math.PI, line_radius],[0,0],[d.PrincipalInvestigator / data_count * 2 * Math.PI, line_radius],
        ];

        var radialLine3 = radialLineGenerator(points3);

        var pt1 = "p" + d.PrincipalInvestigator.toString();
        var pt2 = "p" + d.Analysis.toString();
        var pt3 = "p" + d.Sample.toString();

        d3.select(".path")
          .append("path")
          .attr('d', radialLine1  + "L" + radialLine2.split("L")[1] + "L" + radialLine2.split("L")[2] + "L" + radialLine3.split("L")[1] + "L" + radialLine3.split("L")[2] + "Z") // draw 3 paths into 1
          .attr("class","link " + pt1 + " " + pt2 + " " + pt3);



    });

});




</script>

</body>
</html>
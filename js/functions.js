var diameter = 960,
    radius = diameter / 2,
    innerRadius = radius - 180,
    extra_width = 200;
var Hoverednumber = 0;
var Judge = false;

var div1 = document.getElementById("text1");
var div2 = document.getElementById("text2");


var svg = d3.select("body").append("svg")
            .attr("width", diameter + extra_width)
            .attr("height", diameter + extra_width)
            .append("g")
            .attr("transform", "translate(" + (radius + extra_width/2) + "," + (radius + extra_width/2) + ")");

var line = d3.radialLine()
             .curve(d3.curveBundle.beta(0.85))
             .radius(innerRadius)
             .angle(function(d) { return d / data_count * Math.PI * 2; });


var node = svg.append("g");
    text = svg.append("g");
    link = svg.append("g").attr("class", "path");

var color11 = "#045C2E"; // PI - green
    color1 = "#3E8E64";

    color22 = "#7F2628"; // Action - red
    color2 = "#BF272E";


    color33 = "#043866"; // Sample - blue
    color3 = "#387DB4";


d3.json("data/data1.json", function(error, json){

    var data_count = json.length;
    let circle_radius = innerRadius;
    let text_radius = innerRadius;
    let position = -13;
    let adjust_node_angle = 0.0045;
    let adjust_text_angle = 2;

    node = node.selectAll("circle")
               .data(json)
               .enter().append("circle")
               .attr("transform", function(i, d) { let angle = ((d + position) / data_count + adjust_node_angle) * 2 * Math.PI;
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
                                                   if (90 < angle && angle <= 270) { return "rotate(" + (angle + adjust_text_angle) + ",0,0)translate(320, -6)rotate(180,0,0)"; }
                                                   else { return "rotate(" + (angle + adjust_text_angle) + ",0,0)translate(320, 6)"; }
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


        Hoverednumber = d.number;
        // console.log(Hoverednumber);

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

    }

    function mouseouted(d) {
        Hoverednumber = d.number;

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

        Hoverednumber = 0;
    }

    function mousedown(d) {
        // text.classed("text4", function(l){if (l === d && l.size !== 10) return true});
      div1.textContent = d.name;
      div2.textContent = d.pi;
    }


});


d3.json("data/data2.json", function(error, json){
    var data_count = 55;
    var radialLineGenerator = d3.radialLine()
                            .curve(d3.curveBundle.beta(0.8));

    var line_radius = innerRadius - 7.5;


    json.forEach(function(d){

        // console.log(d);

        var points1 = [
        [d.project / data_count * 2 * Math.PI, line_radius],[0,0],[d.action / data_count * 2 * Math.PI, line_radius],
        ];
        var radialLine1 = radialLineGenerator(points1);


        var points2 = [
        [d.action / data_count * 2 * Math.PI, line_radius],[0,0],[d.sample / data_count * 2 * Math.PI, line_radius],
        ];

        var radialLine2 = radialLineGenerator(points2);


        var points3 = [
        [d.sample / data_count * 2 * Math.PI, line_radius],[0,0],[d.project / data_count * 2 * Math.PI, line_radius],
        ];

        var radialLine3 = radialLineGenerator(points3);

        var pt1 = "p" + d.project.toString();
        var pt2 = "p" + d.action.toString();
        var pt3 = "p" + d.sample.toString();

        d3.select(".path")
          .append("path")
          .attr('d', radialLine1  + "L" + radialLine2.split("L")[1] + "L" + radialLine2.split("L")[2] + "L" + radialLine3.split("L")[1] + "L" + radialLine3.split("L")[2] + "Z") // draw 3 paths into 1
          .attr("class","link " + pt1 + " " + pt2 + " " + pt3);



    });

});
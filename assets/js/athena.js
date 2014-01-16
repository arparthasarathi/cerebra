function athena_check(x, y) {
	var d_but="#but"+x;
	$(d_but).button('loading');
    var z = document.getElementById(y).value;
    if (z.length == 0 || z[0] == ' ') {
        alert('Invalid answer to Question ' + x + ' !');
        var i = "qs" + x;
        document.getElementById(i).innerHTML = "<h5><font color=\"#FF0000\">Invalid Answer ! Please try again!</font></h5>";
		$(d_but).button('reset');
    } else if (x >= 0 && x <= 30) {
        var d = "athena_verify" + x;
        $.post('http://localhost/ros/index.php/ajaxController/check_ans', {
            'q': x,
            'a': z
        }, function (data) {
            document.getElementById(d).innerHTML = "";
            var s = data.result;
			$(d_but).button('reset');
            if (s == "0") {
                alert('Contest Over !');
                document.getElementById("athena_questions").innerHTML = "<h2>Contest Over !</h2>";
            } else if (s == "1") {
                alert('Correct Answer !');
                var j = "q" + x;
                document.getElementById(j).style.display = "none";
                var jj = "qc" + x;
				var jjkk = "wrap" + x;
				$("#"+jjkk).addClass("alert-success");
                document.getElementById(jj).innerHTML = "<strong>Answered Correctly!</strong>";
                document.getElementById('athena_points').innerHTML = data.points;
                if (data.level == "5") {
                    document.getElementById("athena_questions").innerHTML = "<br><h2>Congratulations ! You have completed Athena Main Contest !</h2><br><div style=\"padding-left:250px;\"><h3>THE END !</h3></div><br><div style=\"width:750px; height:225px; border-width: 2px; border-color: #000; border-style:solid; border-color:#CACACA; border-width:2px; padding:5px\"><div style=\" background-color:#F9F9F9; height:225px\"><div style=\"width:265; float:left\"><img src=\"http://mediahive.kurukshetra.org.in/2012/images/athena/theend.jpg\"></div><div style=\"float:right; width:475px; padding-left:10px\"> UN has come to know about the secret pact between Rainbow and Athena. UN doesn&rsquo;t want this to continue. So UN sends a secret message to the four permanent members of Rainbow (excluding you). The message is hidden in the image(in the left). Somehow you have got this information through one of your spy in UN. <br><br><strong> Now what are you gonna do ???</strong></div> </div></div>";
                } else if (l != data.level) {
                    document.getElementById("athena_level").innerHTML = data.level;
                    document.getElementById("athena_questions").innerHTML = data.ques;
                }
            } else if (s == "2") {
                alert('Wrong Answer !');
                var j = "qs" + x;
                document.getElementById(j).innerHTML = "<h5><font color=\"#FF0000\">Wrong Answer ! Please try again!</font></h5>";
                var k = "athena_attempts_" + y;
                document.getElementById(k).innerHTML = data.attempts;
            } else if (s == "3") {
                document.getElementById("containerCenter").innerHTML = "<h2>Please login to participate in Athena !</h2>";
            } else if (s == "4") {
                document.getElementById("containerCenter").innerHTML = "<h2>Contest will begin @ 21:00 IST !</h2>";
            } else if (s == "91") {
                alert('Invalid answer to Question ' + x + ' !');
                var i = "qs" + x;
                document.getElementById(i).innerHTML = "<h5><font color=\"#FF0000\">Invalid Answer ! Please try again!</font></h5>";
            } else if (s == "92") {
                alert('You have already answered Question ' + x + ' !');
                var j = "q" + x;
                document.getElementById(j).innerHTML = "<h2>Answered Correctly !</h2>";
            } else if (s == "93") {
                alert('Invalid Question !');
            }

        }, "json");
    } else alert('Invalid question !');
}

function load_athena_timer(t)
 {

	$('#athena_timer').countdown({until: +t,onExpiry: athena_finish});

 }
 
 function athena_finish()
 {
	 alert('Contest Over !');
	 document.getElementById("athena_questions").innerHTML="<h2>Contest Over !</h2>";
 }
 
 (function (d) {
    var f = 24 * 60 * 60,
        a = 60 * 60,
        b = 60;
    d.fn.countdown = function (g) {
        var r = d.extend({
            callback: function () {},
            timestamp: 0
        }, g);
        var i, p, o, j, q, l;
        e(this, r);
        l = this.find(".position");
        (function n() {
            i = Math.floor((r.timestamp - (new Date())) / 1000);
            if (i < 0) {
                i = 0
            }
            p = Math.floor(i / f);
            k(0, 1, p);
            i -= p * f;
            o = Math.floor(i / a);
            k(2, 3, o);
            i -= o * a;
            j = Math.floor(i / b);
            k(4, 5, j);
            i -= j * b;
            q = i;
            k(6, 7, q);
            r.callback(p, o, j, q);
            setTimeout(n, 1000)
        })();

        function k(m, h, s) {
            c(l.eq(m), Math.floor(s / 10) % 10);
            c(l.eq(h), s % 10)
        }
        return this
    };

    function e(h, g) {
        h.addClass("countdownHolder");
        d.each(["Days", "Hours", "Minutes", "Seconds"], function (j) {
            d('<span class="count' + this + '">').html('<span class="position">					<span class="digit static">0</span>				</span>				<span class="position">					<span class="digit static">0</span>				</span>').appendTo(h);
            if (this != "Seconds") {
                h.append('<span class="countDiv countDiv' + j + '"></span>')
            }
        })
    }
    function c(g, i) {
        var j = g.find(".digit");
        if (j.is(":animated")) {
            return false
        }
        if (g.data("digit") == i) {
            return false
        }
        g.data("digit", i);
        var h = d("<span>", {
            "class": "digit",
            css: {
                top: "-2.1em",
                opacity: 0
            },
            html: i
        });
        j.before(h).removeClass("static").animate({
            top: "2.5em",
            opacity: 0
        }, "fast", function () {
            j.remove()
        });
        h.delay(100).animate({
            top: 0,
            opacity: 1
        }, "fast", function () {
            h.addClass("static")
        })
    }
})(jQuery);
$(function () {
    var b = $("#note"),
        c = new Date(2013, 0, 19),
        a = true;
    if ((new Date()) > c) {
        c = (new Date()).getTime() + 10 * 24 * 60 * 60 * 1000;
        a = false
    }
    $("#k_count").countdown({
        timestamp: c,
        callback: function (h, d, e, g) {
            var f = "";
            f += h + " day" + (h == 1 ? "" : "s") + ", ";
            f += d + " hour" + (d == 1 ? "" : "s") + ", ";
            f += e + " minute" + (e == 1 ? "" : "s") + " and ";
            f += g + " second" + (g == 1 ? "" : "s") + " <br />";
            if (a) {
                f += "Time is up!"
            } else {
                f += ""
            }
            b.html(f)
        }
    })
});

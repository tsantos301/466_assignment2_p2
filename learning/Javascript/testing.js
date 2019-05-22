var testInput = "<question>Which HTML tag is used to enclose javascript?</question><a>&lt;html&gt;</a><b>&lt;Javascript&gt;</b><c>&lt;JS&gt;</c><d>&lt;script&gt;</d><answer>d</answer><question>Which HTML tag is used to enclose javascript?</question><a>&lt;html&gt;</a><b>&lt;Javascript&gt;</b><c>&lt;JS&gt;</c><d>&lt;script&gt;</d><answer>d</answer>";

var output = testInput.split("<question>");

console.log(output);
console.log("hello");
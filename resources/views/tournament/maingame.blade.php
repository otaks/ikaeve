<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tournament</title>
  <!-- Copyright 1998-2021 by Northwoods Software Corporation. -->

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/multi-select.css') }}" rel="stylesheet">
  <link href="{{ asset('css/all.css') }}" rel="stylesheet">

  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="{{ asset('js/all.js') }}" defer></script>
  <script src="{{ asset('js/menu.js') }}" defer></script>
  <script src="{{ asset('js/go.js') }}" defer></script>

  <!-- datetimepicker -->
  <link href="{{ asset('css/jquery.datetimepicker.css') }}" rel="stylesheet">
  <script src="{{ asset('js/jquery.js') }}" defer></script>
  <script src="{{ asset('js/jquery.datetimepicker.full.js') }}" defer></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="{{ asset('js/jquery.multi-select.js') }}" defer></script>
  <script id="code">
    function init() {
      //if (window.goSamples) goSamples();  // init for these samples -- you don't need to call this
      var $ = go.GraphObject.make;  // for conciseness in defining templates

      myDiagram =
        $(go.Diagram, "myDiagramDiv",  // create a Diagram for the DIV HTML element
          {
            "textEditingTool.starting": go.TextEditingTool.SingleClick,
            "textEditingTool.textValidation": isValidScore,
            layout: $(go.TreeLayout, { angle: 180 }),
            "undoManager.isEnabled": false
          });

      // validation function for editing text
      function isValidScore(textblock, oldstr, newstr) {
        if (newstr === "") return true;
        var num = parseInt(newstr, 10);
        chk = !isNaN(num) && num >= 0 && num < {{ ($event->main_score + 1) }};
        if (chk == false) {
            alert('スコアは0~{{ $event->main_score }}を入力してください');
        }


        return chk;
      }

      // define a simple Node template
      myDiagram.nodeTemplate =
        $(go.Node, "Auto",
          { selectable: false },
          $(go.Shape, "RoundedRectangle",
            { fill: '2E7AA0', stroke: '2E7AA0'},
            // Shape.fill is bound to Node.data.color
            new go.Binding("fill", "color")),
          $(go.Panel, "Table",
            $(go.RowColumnDefinition, { column: 0, separatorStroke: "white" }),
            $(go.RowColumnDefinition, { column: 1, separatorStroke: "white", background: "2E7AA0" }),
            $(go.RowColumnDefinition, { row: 0, separatorStroke: "white" }),
            $(go.RowColumnDefinition, { row: 1, separatorStroke: "white" }),
            $(go.TextBlock, "",
              {
                row: 0,
                wrap: go.TextBlock.None, margin: 5, width: 100,
                isMultiline: false, textAlign: 'left',
                font: '8pt  Segoe UI,sans-serif', stroke: 'white'
              },
              new go.Binding("text", "player1").makeTwoWay()),
            $(go.TextBlock, "",
              {
                row: 1,
                wrap: go.TextBlock.None, margin: 5, width: 100,
                isMultiline: false, textAlign: 'left',
                font: '8pt  Segoe UI,sans-serif', stroke: 'white'
              },
              new go.Binding("text", "player2").makeTwoWay()),
            $(go.TextBlock, "",
              {
                column: 1, row: 0,
                wrap: go.TextBlock.None, margin: 2, width: 25,
                isMultiline: false, editable: true, textAlign: 'center',
                font: '8pt  Segoe UI,sans-serif', stroke: 'white'
              },
              new go.Binding("text", "score1").makeTwoWay()),
            $(go.TextBlock, "",
              {
                column: 1, row: 1,
                wrap: go.TextBlock.None, margin: 2, width: 25,
                isMultiline: false, editable: true, textAlign: 'center',
                font: '8pt  Segoe UI,sans-serif', stroke: 'white'
              },
              new go.Binding("text", "score2").makeTwoWay())
          )
        );

      // define the Link template
      myDiagram.linkTemplate =
        $(go.Link,
          {
            routing: go.Link.Orthogonal,
            selectable: false
          },
          $(go.Shape, { strokeWidth: 1, stroke: 'gray' }));


      // Generates the original graph from an array of player names
      function createPairs(players) {
        if (players.length % 2 !== 0) players.push('(empty)');
        var startingGroups = players.length / 2;
        var currentLevel = Math.ceil(Math.log(startingGroups) / Math.log(2));
        var levelGroups = [];
        var currentLevel = Math.ceil(Math.log(startingGroups) / Math.log(2));
        for (var i = 0; i < startingGroups; i++) {
          levelGroups.push(currentLevel + '-' + i);
        }
        var totalGroups = [];
        makeLevel(levelGroups, currentLevel, totalGroups, players);
        return totalGroups;
      }

      function makeLevel(levelGroups, currentLevel, totalGroups, players) {
        currentLevel--;
        var len = levelGroups.length;
        var parentKeys = [];
        var parentNumber = 0;
        var p = '';
        for (var i = 0; i < len; i++) {
          if (parentNumber === 0) {
            p = currentLevel + '-' + parentKeys.length;
            parentKeys.push(p);
          }

          if (players !== null) {
            var p1 = players[i * 2];
            var p2 = players[(i * 2) + 1];
            totalGroups.push({
              key: levelGroups[i], parent: p, player1: p1, player2: p2, parentNumber: parentNumber
            });
          } else {
            totalGroups.push({ key: levelGroups[i], parent: p, parentNumber: parentNumber });
          }

          parentNumber++;
          if (parentNumber > 1) parentNumber = 0;
        }

        // after the first created level there are no player names
        if (currentLevel >= 0) makeLevel(parentKeys, currentLevel, totalGroups, null)
      }

      function makeModel(players) {
        var model = new go.TreeModel(createPairs(players));

        model.addChangedListener(function(e) {
          if (e.propertyName !== 'score1' && e.propertyName !== 'score2') return;
          var data = e.object;
          if (isNaN(data.score1) || isNaN(data.score2)) return;

          // TODO: What happens if score1 and score2 are the same number?

          // both score1 and score2 are numbers,
          // set the name of the higher-score'd player in the advancing (parent) node
          // if the data.parentNumber is 0, then we set player1 on the parent
          // if the data.parentNumber is 1, then we set player2
          var parent = myDiagram.findNodeForKey(data.parent);
          if (parent === null) return;

          var playerName = parseInt(data.score1) > parseInt(data.score2) ? data.player1 : data.player2;
          if (parseInt(data.score1) === parseInt(data.score2)) playerName = "";
          myDiagram.model.setDataProperty(parent.data, (data.parentNumber === 0 ? "player1" : "player2"), playerName);
        });

        myDiagram.model = model;

        // provide initial scores for at most three pairings
        // for (var i = 0; i < Math.min(16, model.nodeDataArray.length); i++) {
        //   var d = model.nodeDataArray[i];
        //   if (d.player1 && d.player2) {
        //     // TODO: doesn't prevent tie scores
        //     model.setDataProperty(d, "score1", Math.floor(Math.random() * 100));
        //     model.setDataProperty(d, "score2", Math.floor(Math.random() * 100));
        //   }
        // }
      }

      makeModel([
        @foreach($teams as $name)
          '{{ $name }}',
        @endforeach
      ]);
    } // end init
  </script>
</head>
<body onload="init()">
  <div id="app">
    <div id="navArea">
      <main>
        <h5>{{ session('eventName') ?? '' }} 本戦</h5>
      </main>
    </div>
    <div class="card-body @if ($isMobile) grid-area @endif">
      <div class="container-fluid @if ($isMobile) top-area @endif">
        @if ($isMobile)
          @include('tournament/nav_sp')
        @else
          @include('tournament/nav')
        @endif
        </div>
        <!--
        <div id="sample">
        -->
        @if ($isMobile)
          <div id="myDiagramDiv" class="bottom-area" style="border: solid 0px black; background: #ffffff; width:100%; height:100%;"></div>
        @else
          <div id="myDiagramDiv" style="border: solid 0px black; background: #ffffff; width:1000px; height:700px;"></div>
        @endif
        <!--
        </div>
      -->
        <input type="hidden" id="url" value="{{ config('user.url') }}">
    </div>
  </div>
</body>
</html>

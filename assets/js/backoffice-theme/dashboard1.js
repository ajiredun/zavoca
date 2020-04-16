/*
Template Name: Adminbite Admin
Author: Wrappixel
Email: niravjoshi87@gmail.com
File: js
*/
$(function() {
  'use strict';
  // ==============================================================
  // City weather
  // ==============================================================
  var chart = new Chartist.Line(
    '#ct-weather',
    {
      labels: ['1PM', '2PM', '3PM', '4PM', '5PM', '6PM'],
      series: [[2, 0, 5, 2, 5, 2]]
    },
    {
      showArea: true,
      showPoint: false,

      chartPadding: {
        left: -35
      },
      axisX: {
        showLabel: true,
        showGrid: false
      },
      axisY: {
        showLabel: false,
        showGrid: true
      },
      fullWidth: true
    }
  );
  // ==============================================================
  // Ct Barchart
  // ==============================================================
  new Chartist.Bar(
    '#weeksales-bar',
    {
      labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
      series: [[50, 40, 30, 70, 50, 20, 30]]
    },
    {
      axisX: {
        showLabel: false,
        showGrid: false
      },

      chartPadding: {
        top: 15,
        left: -25
      },
      axisX: {
        showLabel: true,
        showGrid: false
      },
      axisY: {
        showLabel: false,
        showGrid: false
      },
      fullWidth: true,
      plugins: [Chartist.plugins.tooltip()]
    }
  );
});

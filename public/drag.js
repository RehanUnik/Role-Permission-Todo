$(document).ready(function() {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $('#success_message').html("");
});
const draggables = document.querySelectorAll(".task");
const droppables = document.querySelectorAll(".swim-lane");
var id
var sate
draggables.forEach((task) => {
  task.addEventListener("dragstart", () => {
      id = task.querySelector('[name="id"]').value;
      task.classList.add("is-dragging");
  });
  task.addEventListener("dragend", () => {

      task.classList.remove("is-dragging");

  });
});

droppables.forEach((zone) => {
  zone.addEventListener("dragover", (e) => {
      e.preventDefault();
      sate = zone.getAttribute("data-status");
      const bottomTask = insertAboveTask(zone, e.clientY);
      const curTask = document.querySelector(".is-dragging");

      const zone_ul = zone.querySelector('.todo-list-custom')
      if (!bottomTask) {
          zone_ul.insertAdjacentElement('afterbegin', curTask)
          // apicall();
      } else {
          zone_ul.insertAdjacentElement('afterbegin', curTask)
          // apicall();
      }
      // apicall();

  });
  zone.addEventListener("drop", (e) => {
      apicall();
  });
});

const insertAboveTask = (zone, mouseY) => {
  const els = zone.querySelectorAll(".task:not(.is-dragging)");

  let closestTask = null;
  let closestOffset = Number.NEGATIVE_INFINITY;

  els.forEach((task) => {
      const {
          top
      } = task.getBoundingClientRect();

      const offset = mouseY - top;

      if (offset < 0 && offset > closestOffset) {
          closestOffset = offset;
          closestTask = task;
      }
  });

  return closestTask;
};

function apicall() {
  console.log(id);

  console.log(sate);

  console.log("api call from here");
  $.ajax({
      url: "/statusupdate",
      data: {
          status: sate,
          id: id,
      },
      method: "PUT",
      
      success: function(response) {
          if (response.status == 1) {
              $('#success_message').html("");
              $('#success_message').addClass('alert alert-success');
              $('#success_message').html(response.success);
              id = null;
              sate = null;
          } else if (response.status == 0) {
              $('#success_message').html("");
              $('#success_message').addClass('alert alert-danger');
              $('#success_message').html(response.error);
              id = null;
              sate = null;
          }
      },
      error: function() {
          console.log("error");
          id = null;
          status = null;
      }
  })
}
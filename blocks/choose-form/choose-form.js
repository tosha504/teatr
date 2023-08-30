if (jQuery("section").hasClass("choose-form")) {
  function formAjaxCreat(value, pageContactId) {
    jQuery.ajax({
      type: "post",
      url: localizedObject.ajaxurl,
      data: {
        action: "ajax_choose_form",
        sel_form: value,
        block_name: "acf/choose-form",
        pageContactId: pageContactId,
      },
      beforeSend: function (response) {
        if (!jQuery(".box").hasClass("error")) {
          jQuery(".box").addClass("loader");
        }

        if (jQuery(".wpcf7 form")) {
          // jQuery(".wpcf7 form").hide();
        }
      },
      complete: function (response) {
        jQuery(".box").removeClass("loader");
      },
      success: function (response) {
        jQuery("#form_append").html(response);
        document.querySelectorAll(".wpcf7 > form").forEach(function (e) {
          return wpcf7.init(e);
        });
      },
      error: function (jqXhr, textStatus, errorMessage) {
        if (!jQuery(".box").hasClass("error")) {
          jQuery(".box").addClass("error").append("Something went wrong");
        }
      },
    });
  }

  formAjaxCreat(
    jQuery("#select-form").children().val(),
    jQuery("#select-form").attr("data-page-id")
  );

  jQuery("#select-form").on("change", function () {
    formAjaxCreat(jQuery(this).val(), jQuery(this).attr("data-page-id"));
  });
}

(function ($) {
  Drupal.behaviors.email_page = {
    attach: function (context, settings) {
      var emailPageScrape = $(Drupal.settings.email_page.scrapeElement).html();
      var emailPageForm = $('#email-page-form');
      var emailPageFeedback = $('#email-page-feedback');

      var processForm = function() {
        emailPageForm.find('#edit-submit').hide();
        emailPageFeedback.html('<p>Email is being sent...</p>');
      };

      var formSuccess = function(responseText) {
        emailPageForm.find('#edit-submit').show();
        emailPageFeedback.html(responseText);
      };

      var formError = function() {
        emailPageForm.find('#edit-submit').show();
        emailPageFeedback.html('<p>There was a problem sending the email.</p>');
      };

      emailPageForm.ajaxForm({
        data: { email_page_content: emailPageScrape },
        beforeSubmit: processForm,
        success: formSuccess,
        error: formError
      });
    }
  }
})(jQuery);

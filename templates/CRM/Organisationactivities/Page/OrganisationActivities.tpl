<div class="crm-activity-selector-{$context}">
  <div class="crm-accordion-wrapper crm-search_filters-accordion">
    <div class="crm-accordion-header">
    {ts}Filter by Activity Type{/ts}</a>
    </div><!-- /.crm-accordion-header -->
    <div class="crm-accordion-body">
      <div class="no-border form-layout-compressed activity-search-options">
          <div class="crm-contact-form-block-activity_type_filter_id crm-inline-edit-field">
            {$form.activity_type_filter_id.label} {$form.activity_type_filter_id.html|crmAddClass:big}
          </div>
          <div class="crm-contact-form-block-activity_type_exclude_filter_id crm-inline-edit-field">
            {$form.activity_type_exclude_filter_id.label} {$form.activity_type_exclude_filter_id.html|crmAddClass:big}
          </div>
      </div>
    </div><!-- /.crm-accordion-body -->
  </div><!-- /.crm-accordion-wrapper -->
  <table class="contact-activity-selector-{$context} crm-ajax-table">
    <thead>
    <tr>
      <th data-data="activity_type" class="crm-contact-activity-activity_type">{ts}Type{/ts}</th>
      <th data-data="subject" cell-class="crmf-subject crm-editable" class="crm-contact-activity_subject">{ts}Subject{/ts}</th>
      <th data-data="source_contact_name" class="crm-contact-activity-source_contact">{ts}Added By{/ts}</th>
      <th data-data="target_contact_name" data-orderable="false" class="crm-contact-activity-target_contact">{ts}With{/ts}</th>
      <th data-data="assignee_contact_name" data-orderable="false" class="crm-contact-activity-assignee_contact">{ts}Assigned{/ts}</th>
      <th data-data="activity_date_time" class="crm-contact-activity-activity_date">{ts}Date{/ts}</th>
      <th data-data="status_id" cell-class="crmf-status_id crm-editable" cell-data-type="select" cell-data-refresh="true" class="crm-contact-activity-activity_status">{ts}Status{/ts}</th>
      <th data-data="links" data-orderable="false" class="crm-contact-activity-links">&nbsp;</th>
    </tr>
    </thead>
  </table>

  {literal}
    <script type="text/javascript">
      (function($) {
        var context = {/literal}"{$context}"{literal};
        CRM.$('table.contact-activity-selector-' + context).data({
          "ajax": {
            "url": {/literal}'{crmURL p="civicrm/ajax/organisationactivities" h=0 q="snippet=4&context=$context&cid=$contactId"}'{literal},
            "data": function (d) {
              d.activity_type_id = $('.crm-activity-selector-' + context + ' select#activity_type_filter_id').val(),
              d.activity_type_exclude_id = $('.crm-activity-selector-' + context + ' select#activity_type_exclude_filter_id').val()
            }
          }
        });
        $(function($) {
          $('.activity-search-options :input').change(function(){
            CRM.$('table.contact-activity-selector-' + context).DataTable().draw();
          });
        });
      })(CRM.$);
    </script>
  {/literal}
</div>
{include file="CRM/Case/Form/ActivityToCase.tpl" contactID=$contactId}

define("wpp.admin.widgets",["wpp.model","wpp.locale","jquery"],function(){return function(){wpp=jQuery.extend(!0,"object"==typeof wpp?wpp:{},{widgets:{}}),wpp.widgets._search_properties_widget=function(e){var set_group_or_ungroup=function(){jQuery("input.wpp_toggle_attribute_grouping",e).is(":checked")?jQuery(".wpp_subtle_tabs",e).tabs("option","active",1):jQuery(".wpp_subtle_tabs",e).tabs("option","active",0)},adjust_property_type_option=function(){var count=jQuery("input.wpp_property_types:checked",e).length;2>count?(jQuery(".wpp_attribute_wrapper.property_type",e).hide(),jQuery(".wpp_attribute_wrapper.property_type input",e).attr("checked",!1)):jQuery(".wpp_attribute_wrapper.property_type",e).show()};adjust_property_type_option(),jQuery(".wpp_all_attributes .wpp_sortable_attributes",e).sortable(),jQuery(".wpp_subtle_tabs",e).tabs({select:function(event,ui){jQuery("input.wpp_toggle_attribute_grouping",e).attr("checked",0==ui.index?!1:!0)}}),set_group_or_ungroup(),jQuery("input.wpp_property_types").change(function(){adjust_property_type_option()}),jQuery("input.wpp_toggle_attribute_grouping").change(function(){set_group_or_ungroup()})},wpp.widgets._property_attributes_widget=function(e){jQuery(".wpp_sortable_attributes",e).sortable()},wpp.widgets.run=function(){jQuery(".wpp_widget").each(function(i,e){if(e=jQuery(e),isNaN(parseInt(e.data("widget_number"))))return null;if(e.hasClass("wpp_widget_loaded"))return null;switch(e.addClass("wpp_widget_loaded"),e.data("widget")){case"search_properties_widget":wpp.widgets._search_properties_widget(e);break;case"property_attributes_widget":wpp.widgets._property_attributes_widget(e)}})},jQuery(document).ready(function(){jQuery(document).live("ajaxComplete",function(){wpp.widgets.run()}),jQuery("div.widgets-sortables").on("sortstop",function(){setTimeout(function(){wpp.widgets.run()},100)}),wpp.widgets.run()})}});
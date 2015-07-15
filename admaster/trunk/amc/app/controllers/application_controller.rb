class ApplicationController < ActionController::Base
  protect_from_forgery

  def init_menus (select_menu)
    menus = [
             {:name => :Campaigns, :href => '/campaigns', :icon_class => 'sp_4iomxd sx_3b82b1'},
             {:name => :Creatives, :href => '/creatives', :icon_class => 'sp_1hgi74 sx_509d99'},
             {:name => :Reporting, :href => '/reports', :icon_class => 'sp_4iomxd sx_fd315a'},
             {:name => :Billing,   :href => '/billings', :icon_class => 'sp_8lnh2w sx_8fd705'},
             {:name => :Settings,  :href => '/settings', :icon_class => 'sp_4iomxd sx_58352a'}
            ];
    menus.each do |menu|
      if select_menu == menu[:name]
        menu[:class] = 'sideNavItem selectedItem'
      else
        menu[:class] = 'sideNavItem'
      end
    end

    menus
  end
end

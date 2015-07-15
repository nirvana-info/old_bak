class SettingsController < ApplicationController

  def index

    render :locals => { :menus => init_menus(:Settings) }
  end

end

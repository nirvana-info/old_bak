class CampaignsController < ApplicationController

  def index

    render :locals => { :menus => init_menus(:Campaigns) }
  end

  def add

    render :layout => 'fullpage'
  end

end

class BillingsController < ApplicationController

  def index

    render :locals => { :menus => init_menus(:Billing) }
  end

end

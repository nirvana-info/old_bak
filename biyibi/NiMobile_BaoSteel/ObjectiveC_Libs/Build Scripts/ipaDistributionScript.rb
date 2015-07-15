require 'fileutils.rb'
require 'rubygems'
require 'plist'
require 'optparse'
#require 'httpclient'


# Before use, you must install the following gems:
#   plist ("sudo gem install plist" from Terminal)
#   httpclient ("sudo gem install httpclient" from Terminal)

class ExecutablesMaker

BUILD_FOLDER_PATH = ENV['CONFIGURATION_BUILD_DIR']
BINARY_EXTENSION = "app"
DSYM_EXTENSION = "app.dSYM"

def initialize(args)
  
    opts = OptionParser.new do |opts|
    opts.banner = "Usage: ipaDistributionScript.rb [options]"
    
    opts.separator ""
    opts.separator "Specific options:"
    
    opts.on("-n", "--name APPLICATION_NAME",
                    "Set to your application name") do |name|
        @application_name = name
    end
    
    opts.on("-y", "--display_name [DISPLAY_NAME]",
                "Display name on distribution site.  Will default to application name.") do |display_name|
                  @display_name = display_name
    end
    
    opts.on("-l", "--plist_path PLIST_LOCATION",
                    "The location of your applications plist file") do |plist|
        @plist_path = plist
    end
    
    opts.on("-a", "--artwork_location ITUNES_ARTWORK",
                    "The location of your iTunes artwork file") do |artwork|
        @original_itunes_artwork_path = artwork
    end
    
    opts.on("-p", "--provisioning_profile PROFILE",
                    "location of provisioning file") do |profile|
        @provisioning_profile = File.expand_path(profile)
    end
    
    opts.on("-s", "--server SERVER",
                    "PHP server ") do |server|
        @server = server
    end
    
    opts.on("-u", "--username USERNAME",
                    "username for PHP server") do |username|
        @username = username
    end
    
    opts.on("-w", "--password PASSWORD",
                    "password for PHP server") do |password|
        @password = password
    end
    
    opts.on("-d", "--client_directory DIRECTORY",
                    "remote client directory on server") do |directory|
        @remote_directory = directory
    end
    
    opts.on("-c", "--scheme SCHEME",
                    "URI Scheme") do |scheme|
        @uri_scheme = scheme
    end
    
    opts.on_tail("-h", "--help", "Show this message") do
        puts opts
        exit
    end

  end

  opts.parse!(args)
  
  if ( nil == @application_name || 
     nil == @plist_path || 
     nil == @original_itunes_artwork_path)
    puts opts
    exit
  end
  ### Pull the plist into a Hash ###
  
  # Modify this path if you move Info.plist from the root project folder
  plist_hash = Plist::parse_xml(@plist_path)
  
  # Pull the current version number from the plist hash. It will be used to name the ipa #
  @current_version = plist_hash["CFBundleVersion"] # Example: v1.0b20
  @bundle_identifier = ENV["BUNDLE_IDENTIFIER"]
  
  # Clear out old directory (if necessary)
  FileUtils.remove_dir "Executables/#{@bundle_identifier}", :force => true
 
end

## Make sure build configuration is set correctly ###
def verifyBuildConfig
  # Make sure you're building with the "Distribution" configuration
  if (ENV['BUILD_STYLE'] !~ /Distribution$/) then
    abort("Build style is #{ENV['BUILD_STYLE']}, not Distribution. Aborting.")
  # Make sure you're building to the Device, not the Simulator
  elsif (ENV['PLATFORM_NAME'] != "iphoneos") then
    abort("Platform name is #{ENV['PLATFORM_NAME']}, not iphoneos. Aborting.")
  end
  
  exit if(ENV['BUILD_STYLE'] =~ /App Store/)
  
end

### Create the .ipa ###
def createIPA
 root_folder_path = "Executables/#{@bundle_identifier}"

 # The folder that will eventually be zipped into an ipa
 ipa_folder_path = "#{root_folder_path}/#{@application_name}_#{@current_version}"
 
 # Make the payload folder
 payload_folder_path = "#{ipa_folder_path}/Payload"
 FileUtils.mkdir_p payload_folder_path
 
 # Move the binary to the payload folder
 binary_name = "#{@application_name}.#{BINARY_EXTENSION}"
 FileUtils.cp_r "#{BUILD_FOLDER_PATH}/#{binary_name}", "#{payload_folder_path}/#{binary_name}"
 
 # Create a copy of the icon image with the iTunesArtwork name
 ipa_itunes_artwork_path = "#{ipa_folder_path}/iTunesArtwork"
 FileUtils.cp @original_itunes_artwork_path, ipa_itunes_artwork_path
 
 ipa_file = "#{@application_name.gsub(' ','_')}_v#{@current_version}.ipa"
 
 # compress the ipa folder
 system("cd '#{ipa_folder_path}'; /usr/bin/zip -yr \"../#{ipa_file}\" Payload iTunesArtwork")
 
 @ipa_path = File.expand_path("#{root_folder_path}/#{ipa_file}")
 puts @ipa_path
 
 #remove the directory we zipped contents from
 FileUtils.rmtree(ipa_folder_path)
 
end

### Create the zipped .dSYM ###
def createZippedDSYM
 root_folder_path = "Executables/#{@bundle_identifier}"
 
 # Copy the original
 dsym_name = "#{@application_name}.#{DSYM_EXTENSION}"
 FileUtils.cp_r "#{BUILD_FOLDER_PATH}/#{dsym_name}",  "Executables/#{@bundle_identifier}/#{dsym_name}"
 
 # compress the dsym file
 system("cd '#{root_folder_path}'; tar -cvzpf '#{dsym_name}.tgz' '#{dsym_name}'")

 #remove the old dsym dir
 FileUtils.rmtree("#{root_folder_path}/#{dsym_name}")
   
end

def cleanUp
  
end

def uploadBinary
  
    if nil == @uri_scheme
      @uri_scheme = "https"
    end
  
   #post files to website
   base_url = "#{@uri_scheme}://#{@server}/#{@remote_directory}/"
   
   puts "POSTing to #{base_url}upload.php"
   
   @display_name ||= @application_name
   
   puts "Display name: #{@display_name}"
   
   client = HTTPClient.new
   client.set_auth(base_url, @username, @password)
   res = client.post "#{base_url}upload.php", { :bundle_identifier => @bundle_identifier, 
                  :current_version => @current_version, 
                  :application_name => @application_name,
                  :display_name => @display_name ,
                  :ipa_file => File.new(@ipa_path),
                  :provisioning_profile => File.new(@provisioning_profile)
                }
                
    puts res.inspect
end

end

# Be sure to change the application name to match the original target's PRODUCT_NAME.
em = ExecutablesMaker.new(ARGV)
em.verifyBuildConfig
em.createIPA
em.createZippedDSYM
# em.uploadBinary





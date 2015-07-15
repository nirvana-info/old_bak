require 'fileutils.rb'
require 'rubygems'
require 'plist'
require 'optparse'
require 'httpclient'


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
    
    opts.on("-l", "--plist_path PLIST_LOCATION",
                    "The location of your applications plist file") do |plist|
        @plist_path = plist
    end
    
    opts.on_tail("-h", "--help", "Show this message") do
        puts opts
        exit
    end

  end

  opts.parse!(args)
  
  if ( nil == @application_name || 
     nil == @plist_path)
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

### Make sure build configuration is set correctly ###
def verify_build_config
  # Make sure you're building with the "App Store Distribution" configuration
  if (ENV['BUILD_STYLE'] != "App Store Distribution") then
    abort("Build style is #{ENV['BUILD_STYLE']}, not App Store Distribution. Aborting.")
  # Make sure you're building to the Device, not the Simulator
  elsif (ENV['PLATFORM_NAME'] != "iphoneos") then
    abort("Platform name is #{ENV['PLATFORM_NAME']}, not iphoneos. Aborting.")
  end
end

def define_and_create_bundle_executables_folder_path
  
  # (RIP Mar 09, 2011) - Define the variable
  @bundle_executables_folder_path = "Executables/#{@bundle_identifier}"
  
  # (RIP Mar 09, 2011) - Create a bundle identifier folder under Executables/
  FileUtils.mkdir_p "#{@bundle_executables_folder_path}"
  
end

### Create the zipped .app ###
def copy_and_compress_binary
 
 # (RIP Mar 09, 2011) - Define some variables.
 binary_filename = "#{@application_name}.#{BINARY_EXTENSION}"
 zip_filename = "#{@application_name.gsub(' ','_')}.zip"
 
 # (RIP Mar 09, 2011) - Compress the binary into a zip file.
 # (RIP Apr 07, 2011) - The .app bundle includes a symlink to _CodeSignature/CodeResources. You must include -y in the zip options
 # to store symlinks in the archive. If this isn't done, the binary is invalid and Apple will not accept. More info can be found
 # here (see the answer from shirikodama) - http://stackoverflow.com/questions/47941/invalid-iphone-application-binary
 system("cd '#{BUILD_FOLDER_PATH}'; /usr/bin/zip -yr '#{zip_filename}' '#{binary_filename}'")
 system("cp '#{BUILD_FOLDER_PATH}/#{zip_filename}' '#{@bundle_executables_folder_path}/#{zip_filename}'")
 
end

### Create the tar-ed .dSYM ###
def copy_and_compress_dSYM
  
 # (RIP Mar 09, 2011) - Define some variables.
 dsym_filename = "#{@application_name}.#{DSYM_EXTENSION}"
 
 # compress the dsym file
 system("cd '#{BUILD_FOLDER_PATH}'; tar -cvzpf '#{dsym_filename}.tgz' '#{dsym_filename}'")
 system("cp '#{BUILD_FOLDER_PATH}/#{dsym_filename}.tgz' '#{@bundle_executables_folder_path}/#{dsym_filename}.tgz'")
  
end

def open_application_loader
  system("open '/Developer/Applications/Utilities/Application Loader.app'")
end

end #  << ExecutablesMaker

# Be sure to change the application name to match the original target's PRODUCT_NAME.
em = ExecutablesMaker.new(ARGV)
em.verify_build_config
em.define_and_create_bundle_executables_folder_path
em.copy_and_compress_binary
em.copy_and_compress_dSYM
#em.open_application_loader

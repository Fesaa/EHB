// Generated by the protocol buffer compiler.  DO NOT EDIT!
// source: packets.proto

// Protobuf Java Version: 3.25.1
package art.ameliah.pulsewatcher.proto;

/**
 * Protobuf type {@code art.ameliah.pulsewatcher.C2SMetricPacket}
 */
public final class C2SMetricPacket extends
    com.google.protobuf.GeneratedMessageV3 implements
    // @@protoc_insertion_point(message_implements:art.ameliah.pulsewatcher.C2SMetricPacket)
    C2SMetricPacketOrBuilder {
private static final long serialVersionUID = 0L;
  // Use C2SMetricPacket.newBuilder() to construct.
  private C2SMetricPacket(com.google.protobuf.GeneratedMessageV3.Builder<?> builder) {
    super(builder);
  }
  private C2SMetricPacket() {
  }

  @java.lang.Override
  @SuppressWarnings({"unused"})
  protected java.lang.Object newInstance(
      UnusedPrivateParameter unused) {
    return new C2SMetricPacket();
  }

  public static final com.google.protobuf.Descriptors.Descriptor
      getDescriptor() {
    return art.ameliah.pulsewatcher.proto.Packets.internal_static_art_ameliah_pulsewatcher_C2SMetricPacket_descriptor;
  }

  @java.lang.Override
  protected com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
      internalGetFieldAccessorTable() {
    return art.ameliah.pulsewatcher.proto.Packets.internal_static_art_ameliah_pulsewatcher_C2SMetricPacket_fieldAccessorTable
        .ensureFieldAccessorsInitialized(
            art.ameliah.pulsewatcher.proto.C2SMetricPacket.class, art.ameliah.pulsewatcher.proto.C2SMetricPacket.Builder.class);
  }

  private int metricsCase_ = 0;
  @SuppressWarnings("serial")
  private java.lang.Object metrics_;
  public enum MetricsCase
      implements com.google.protobuf.Internal.EnumLite,
          com.google.protobuf.AbstractMessage.InternalOneOfEnum {
    APICLIENTMETRIC(3),
    METRICS_NOT_SET(0);
    private final int value;
    private MetricsCase(int value) {
      this.value = value;
    }
    /**
     * @param value The number of the enum to look for.
     * @return The enum associated with the given number.
     * @deprecated Use {@link #forNumber(int)} instead.
     */
    @java.lang.Deprecated
    public static MetricsCase valueOf(int value) {
      return forNumber(value);
    }

    public static MetricsCase forNumber(int value) {
      switch (value) {
        case 3: return APICLIENTMETRIC;
        case 0: return METRICS_NOT_SET;
        default: return null;
      }
    }
    public int getNumber() {
      return this.value;
    }
  };

  public MetricsCase
  getMetricsCase() {
    return MetricsCase.forNumber(
        metricsCase_);
  }

  public static final int RAMUSAGE_FIELD_NUMBER = 1;
  private long ramUsage_ = 0L;
  /**
   * <code>int64 ramUsage = 1;</code>
   * @return The ramUsage.
   */
  @java.lang.Override
  public long getRamUsage() {
    return ramUsage_;
  }

  public static final int UPTIME_FIELD_NUMBER = 2;
  private long uptime_ = 0L;
  /**
   * <code>int64 uptime = 2;</code>
   * @return The uptime.
   */
  @java.lang.Override
  public long getUptime() {
    return uptime_;
  }

  public static final int APICLIENTMETRIC_FIELD_NUMBER = 3;
  /**
   * <code>.art.ameliah.pulsewatcher.APIClientMetric apiClientMetric = 3;</code>
   * @return Whether the apiClientMetric field is set.
   */
  @java.lang.Override
  public boolean hasApiClientMetric() {
    return metricsCase_ == 3;
  }
  /**
   * <code>.art.ameliah.pulsewatcher.APIClientMetric apiClientMetric = 3;</code>
   * @return The apiClientMetric.
   */
  @java.lang.Override
  public art.ameliah.pulsewatcher.proto.APIClientMetric getApiClientMetric() {
    if (metricsCase_ == 3) {
       return (art.ameliah.pulsewatcher.proto.APIClientMetric) metrics_;
    }
    return art.ameliah.pulsewatcher.proto.APIClientMetric.getDefaultInstance();
  }
  /**
   * <code>.art.ameliah.pulsewatcher.APIClientMetric apiClientMetric = 3;</code>
   */
  @java.lang.Override
  public art.ameliah.pulsewatcher.proto.APIClientMetricOrBuilder getApiClientMetricOrBuilder() {
    if (metricsCase_ == 3) {
       return (art.ameliah.pulsewatcher.proto.APIClientMetric) metrics_;
    }
    return art.ameliah.pulsewatcher.proto.APIClientMetric.getDefaultInstance();
  }

  private byte memoizedIsInitialized = -1;
  @java.lang.Override
  public final boolean isInitialized() {
    byte isInitialized = memoizedIsInitialized;
    if (isInitialized == 1) return true;
    if (isInitialized == 0) return false;

    memoizedIsInitialized = 1;
    return true;
  }

  @java.lang.Override
  public void writeTo(com.google.protobuf.CodedOutputStream output)
                      throws java.io.IOException {
    if (ramUsage_ != 0L) {
      output.writeInt64(1, ramUsage_);
    }
    if (uptime_ != 0L) {
      output.writeInt64(2, uptime_);
    }
    if (metricsCase_ == 3) {
      output.writeMessage(3, (art.ameliah.pulsewatcher.proto.APIClientMetric) metrics_);
    }
    getUnknownFields().writeTo(output);
  }

  @java.lang.Override
  public int getSerializedSize() {
    int size = memoizedSize;
    if (size != -1) return size;

    size = 0;
    if (ramUsage_ != 0L) {
      size += com.google.protobuf.CodedOutputStream
        .computeInt64Size(1, ramUsage_);
    }
    if (uptime_ != 0L) {
      size += com.google.protobuf.CodedOutputStream
        .computeInt64Size(2, uptime_);
    }
    if (metricsCase_ == 3) {
      size += com.google.protobuf.CodedOutputStream
        .computeMessageSize(3, (art.ameliah.pulsewatcher.proto.APIClientMetric) metrics_);
    }
    size += getUnknownFields().getSerializedSize();
    memoizedSize = size;
    return size;
  }

  @java.lang.Override
  public boolean equals(final java.lang.Object obj) {
    if (obj == this) {
     return true;
    }
    if (!(obj instanceof art.ameliah.pulsewatcher.proto.C2SMetricPacket)) {
      return super.equals(obj);
    }
    art.ameliah.pulsewatcher.proto.C2SMetricPacket other = (art.ameliah.pulsewatcher.proto.C2SMetricPacket) obj;

    if (getRamUsage()
        != other.getRamUsage()) return false;
    if (getUptime()
        != other.getUptime()) return false;
    if (!getMetricsCase().equals(other.getMetricsCase())) return false;
    switch (metricsCase_) {
      case 3:
        if (!getApiClientMetric()
            .equals(other.getApiClientMetric())) return false;
        break;
      case 0:
      default:
    }
    if (!getUnknownFields().equals(other.getUnknownFields())) return false;
    return true;
  }

  @java.lang.Override
  public int hashCode() {
    if (memoizedHashCode != 0) {
      return memoizedHashCode;
    }
    int hash = 41;
    hash = (19 * hash) + getDescriptor().hashCode();
    hash = (37 * hash) + RAMUSAGE_FIELD_NUMBER;
    hash = (53 * hash) + com.google.protobuf.Internal.hashLong(
        getRamUsage());
    hash = (37 * hash) + UPTIME_FIELD_NUMBER;
    hash = (53 * hash) + com.google.protobuf.Internal.hashLong(
        getUptime());
    switch (metricsCase_) {
      case 3:
        hash = (37 * hash) + APICLIENTMETRIC_FIELD_NUMBER;
        hash = (53 * hash) + getApiClientMetric().hashCode();
        break;
      case 0:
      default:
    }
    hash = (29 * hash) + getUnknownFields().hashCode();
    memoizedHashCode = hash;
    return hash;
  }

  public static art.ameliah.pulsewatcher.proto.C2SMetricPacket parseFrom(
      java.nio.ByteBuffer data)
      throws com.google.protobuf.InvalidProtocolBufferException {
    return PARSER.parseFrom(data);
  }
  public static art.ameliah.pulsewatcher.proto.C2SMetricPacket parseFrom(
      java.nio.ByteBuffer data,
      com.google.protobuf.ExtensionRegistryLite extensionRegistry)
      throws com.google.protobuf.InvalidProtocolBufferException {
    return PARSER.parseFrom(data, extensionRegistry);
  }
  public static art.ameliah.pulsewatcher.proto.C2SMetricPacket parseFrom(
      com.google.protobuf.ByteString data)
      throws com.google.protobuf.InvalidProtocolBufferException {
    return PARSER.parseFrom(data);
  }
  public static art.ameliah.pulsewatcher.proto.C2SMetricPacket parseFrom(
      com.google.protobuf.ByteString data,
      com.google.protobuf.ExtensionRegistryLite extensionRegistry)
      throws com.google.protobuf.InvalidProtocolBufferException {
    return PARSER.parseFrom(data, extensionRegistry);
  }
  public static art.ameliah.pulsewatcher.proto.C2SMetricPacket parseFrom(byte[] data)
      throws com.google.protobuf.InvalidProtocolBufferException {
    return PARSER.parseFrom(data);
  }
  public static art.ameliah.pulsewatcher.proto.C2SMetricPacket parseFrom(
      byte[] data,
      com.google.protobuf.ExtensionRegistryLite extensionRegistry)
      throws com.google.protobuf.InvalidProtocolBufferException {
    return PARSER.parseFrom(data, extensionRegistry);
  }
  public static art.ameliah.pulsewatcher.proto.C2SMetricPacket parseFrom(java.io.InputStream input)
      throws java.io.IOException {
    return com.google.protobuf.GeneratedMessageV3
        .parseWithIOException(PARSER, input);
  }
  public static art.ameliah.pulsewatcher.proto.C2SMetricPacket parseFrom(
      java.io.InputStream input,
      com.google.protobuf.ExtensionRegistryLite extensionRegistry)
      throws java.io.IOException {
    return com.google.protobuf.GeneratedMessageV3
        .parseWithIOException(PARSER, input, extensionRegistry);
  }

  public static art.ameliah.pulsewatcher.proto.C2SMetricPacket parseDelimitedFrom(java.io.InputStream input)
      throws java.io.IOException {
    return com.google.protobuf.GeneratedMessageV3
        .parseDelimitedWithIOException(PARSER, input);
  }

  public static art.ameliah.pulsewatcher.proto.C2SMetricPacket parseDelimitedFrom(
      java.io.InputStream input,
      com.google.protobuf.ExtensionRegistryLite extensionRegistry)
      throws java.io.IOException {
    return com.google.protobuf.GeneratedMessageV3
        .parseDelimitedWithIOException(PARSER, input, extensionRegistry);
  }
  public static art.ameliah.pulsewatcher.proto.C2SMetricPacket parseFrom(
      com.google.protobuf.CodedInputStream input)
      throws java.io.IOException {
    return com.google.protobuf.GeneratedMessageV3
        .parseWithIOException(PARSER, input);
  }
  public static art.ameliah.pulsewatcher.proto.C2SMetricPacket parseFrom(
      com.google.protobuf.CodedInputStream input,
      com.google.protobuf.ExtensionRegistryLite extensionRegistry)
      throws java.io.IOException {
    return com.google.protobuf.GeneratedMessageV3
        .parseWithIOException(PARSER, input, extensionRegistry);
  }

  @java.lang.Override
  public Builder newBuilderForType() { return newBuilder(); }
  public static Builder newBuilder() {
    return DEFAULT_INSTANCE.toBuilder();
  }
  public static Builder newBuilder(art.ameliah.pulsewatcher.proto.C2SMetricPacket prototype) {
    return DEFAULT_INSTANCE.toBuilder().mergeFrom(prototype);
  }
  @java.lang.Override
  public Builder toBuilder() {
    return this == DEFAULT_INSTANCE
        ? new Builder() : new Builder().mergeFrom(this);
  }

  @java.lang.Override
  protected Builder newBuilderForType(
      com.google.protobuf.GeneratedMessageV3.BuilderParent parent) {
    Builder builder = new Builder(parent);
    return builder;
  }
  /**
   * Protobuf type {@code art.ameliah.pulsewatcher.C2SMetricPacket}
   */
  public static final class Builder extends
      com.google.protobuf.GeneratedMessageV3.Builder<Builder> implements
      // @@protoc_insertion_point(builder_implements:art.ameliah.pulsewatcher.C2SMetricPacket)
      art.ameliah.pulsewatcher.proto.C2SMetricPacketOrBuilder {
    public static final com.google.protobuf.Descriptors.Descriptor
        getDescriptor() {
      return art.ameliah.pulsewatcher.proto.Packets.internal_static_art_ameliah_pulsewatcher_C2SMetricPacket_descriptor;
    }

    @java.lang.Override
    protected com.google.protobuf.GeneratedMessageV3.FieldAccessorTable
        internalGetFieldAccessorTable() {
      return art.ameliah.pulsewatcher.proto.Packets.internal_static_art_ameliah_pulsewatcher_C2SMetricPacket_fieldAccessorTable
          .ensureFieldAccessorsInitialized(
              art.ameliah.pulsewatcher.proto.C2SMetricPacket.class, art.ameliah.pulsewatcher.proto.C2SMetricPacket.Builder.class);
    }

    // Construct using art.ameliah.pulsewatcher.proto.C2SMetricPacket.newBuilder()
    private Builder() {

    }

    private Builder(
        com.google.protobuf.GeneratedMessageV3.BuilderParent parent) {
      super(parent);

    }
    @java.lang.Override
    public Builder clear() {
      super.clear();
      bitField0_ = 0;
      ramUsage_ = 0L;
      uptime_ = 0L;
      if (apiClientMetricBuilder_ != null) {
        apiClientMetricBuilder_.clear();
      }
      metricsCase_ = 0;
      metrics_ = null;
      return this;
    }

    @java.lang.Override
    public com.google.protobuf.Descriptors.Descriptor
        getDescriptorForType() {
      return art.ameliah.pulsewatcher.proto.Packets.internal_static_art_ameliah_pulsewatcher_C2SMetricPacket_descriptor;
    }

    @java.lang.Override
    public art.ameliah.pulsewatcher.proto.C2SMetricPacket getDefaultInstanceForType() {
      return art.ameliah.pulsewatcher.proto.C2SMetricPacket.getDefaultInstance();
    }

    @java.lang.Override
    public art.ameliah.pulsewatcher.proto.C2SMetricPacket build() {
      art.ameliah.pulsewatcher.proto.C2SMetricPacket result = buildPartial();
      if (!result.isInitialized()) {
        throw newUninitializedMessageException(result);
      }
      return result;
    }

    @java.lang.Override
    public art.ameliah.pulsewatcher.proto.C2SMetricPacket buildPartial() {
      art.ameliah.pulsewatcher.proto.C2SMetricPacket result = new art.ameliah.pulsewatcher.proto.C2SMetricPacket(this);
      if (bitField0_ != 0) { buildPartial0(result); }
      buildPartialOneofs(result);
      onBuilt();
      return result;
    }

    private void buildPartial0(art.ameliah.pulsewatcher.proto.C2SMetricPacket result) {
      int from_bitField0_ = bitField0_;
      if (((from_bitField0_ & 0x00000001) != 0)) {
        result.ramUsage_ = ramUsage_;
      }
      if (((from_bitField0_ & 0x00000002) != 0)) {
        result.uptime_ = uptime_;
      }
    }

    private void buildPartialOneofs(art.ameliah.pulsewatcher.proto.C2SMetricPacket result) {
      result.metricsCase_ = metricsCase_;
      result.metrics_ = this.metrics_;
      if (metricsCase_ == 3 &&
          apiClientMetricBuilder_ != null) {
        result.metrics_ = apiClientMetricBuilder_.build();
      }
    }

    @java.lang.Override
    public Builder clone() {
      return super.clone();
    }
    @java.lang.Override
    public Builder setField(
        com.google.protobuf.Descriptors.FieldDescriptor field,
        java.lang.Object value) {
      return super.setField(field, value);
    }
    @java.lang.Override
    public Builder clearField(
        com.google.protobuf.Descriptors.FieldDescriptor field) {
      return super.clearField(field);
    }
    @java.lang.Override
    public Builder clearOneof(
        com.google.protobuf.Descriptors.OneofDescriptor oneof) {
      return super.clearOneof(oneof);
    }
    @java.lang.Override
    public Builder setRepeatedField(
        com.google.protobuf.Descriptors.FieldDescriptor field,
        int index, java.lang.Object value) {
      return super.setRepeatedField(field, index, value);
    }
    @java.lang.Override
    public Builder addRepeatedField(
        com.google.protobuf.Descriptors.FieldDescriptor field,
        java.lang.Object value) {
      return super.addRepeatedField(field, value);
    }
    @java.lang.Override
    public Builder mergeFrom(com.google.protobuf.Message other) {
      if (other instanceof art.ameliah.pulsewatcher.proto.C2SMetricPacket) {
        return mergeFrom((art.ameliah.pulsewatcher.proto.C2SMetricPacket)other);
      } else {
        super.mergeFrom(other);
        return this;
      }
    }

    public Builder mergeFrom(art.ameliah.pulsewatcher.proto.C2SMetricPacket other) {
      if (other == art.ameliah.pulsewatcher.proto.C2SMetricPacket.getDefaultInstance()) return this;
      if (other.getRamUsage() != 0L) {
        setRamUsage(other.getRamUsage());
      }
      if (other.getUptime() != 0L) {
        setUptime(other.getUptime());
      }
      switch (other.getMetricsCase()) {
        case APICLIENTMETRIC: {
          mergeApiClientMetric(other.getApiClientMetric());
          break;
        }
        case METRICS_NOT_SET: {
          break;
        }
      }
      this.mergeUnknownFields(other.getUnknownFields());
      onChanged();
      return this;
    }

    @java.lang.Override
    public final boolean isInitialized() {
      return true;
    }

    @java.lang.Override
    public Builder mergeFrom(
        com.google.protobuf.CodedInputStream input,
        com.google.protobuf.ExtensionRegistryLite extensionRegistry)
        throws java.io.IOException {
      if (extensionRegistry == null) {
        throw new java.lang.NullPointerException();
      }
      try {
        boolean done = false;
        while (!done) {
          int tag = input.readTag();
          switch (tag) {
            case 0:
              done = true;
              break;
            case 8: {
              ramUsage_ = input.readInt64();
              bitField0_ |= 0x00000001;
              break;
            } // case 8
            case 16: {
              uptime_ = input.readInt64();
              bitField0_ |= 0x00000002;
              break;
            } // case 16
            case 26: {
              input.readMessage(
                  getApiClientMetricFieldBuilder().getBuilder(),
                  extensionRegistry);
              metricsCase_ = 3;
              break;
            } // case 26
            default: {
              if (!super.parseUnknownField(input, extensionRegistry, tag)) {
                done = true; // was an endgroup tag
              }
              break;
            } // default:
          } // switch (tag)
        } // while (!done)
      } catch (com.google.protobuf.InvalidProtocolBufferException e) {
        throw e.unwrapIOException();
      } finally {
        onChanged();
      } // finally
      return this;
    }
    private int metricsCase_ = 0;
    private java.lang.Object metrics_;
    public MetricsCase
        getMetricsCase() {
      return MetricsCase.forNumber(
          metricsCase_);
    }

    public Builder clearMetrics() {
      metricsCase_ = 0;
      metrics_ = null;
      onChanged();
      return this;
    }

    private int bitField0_;

    private long ramUsage_ ;
    /**
     * <code>int64 ramUsage = 1;</code>
     * @return The ramUsage.
     */
    @java.lang.Override
    public long getRamUsage() {
      return ramUsage_;
    }
    /**
     * <code>int64 ramUsage = 1;</code>
     * @param value The ramUsage to set.
     * @return This builder for chaining.
     */
    public Builder setRamUsage(long value) {

      ramUsage_ = value;
      bitField0_ |= 0x00000001;
      onChanged();
      return this;
    }
    /**
     * <code>int64 ramUsage = 1;</code>
     * @return This builder for chaining.
     */
    public Builder clearRamUsage() {
      bitField0_ = (bitField0_ & ~0x00000001);
      ramUsage_ = 0L;
      onChanged();
      return this;
    }

    private long uptime_ ;
    /**
     * <code>int64 uptime = 2;</code>
     * @return The uptime.
     */
    @java.lang.Override
    public long getUptime() {
      return uptime_;
    }
    /**
     * <code>int64 uptime = 2;</code>
     * @param value The uptime to set.
     * @return This builder for chaining.
     */
    public Builder setUptime(long value) {

      uptime_ = value;
      bitField0_ |= 0x00000002;
      onChanged();
      return this;
    }
    /**
     * <code>int64 uptime = 2;</code>
     * @return This builder for chaining.
     */
    public Builder clearUptime() {
      bitField0_ = (bitField0_ & ~0x00000002);
      uptime_ = 0L;
      onChanged();
      return this;
    }

    private com.google.protobuf.SingleFieldBuilderV3<
        art.ameliah.pulsewatcher.proto.APIClientMetric, art.ameliah.pulsewatcher.proto.APIClientMetric.Builder, art.ameliah.pulsewatcher.proto.APIClientMetricOrBuilder> apiClientMetricBuilder_;
    /**
     * <code>.art.ameliah.pulsewatcher.APIClientMetric apiClientMetric = 3;</code>
     * @return Whether the apiClientMetric field is set.
     */
    @java.lang.Override
    public boolean hasApiClientMetric() {
      return metricsCase_ == 3;
    }
    /**
     * <code>.art.ameliah.pulsewatcher.APIClientMetric apiClientMetric = 3;</code>
     * @return The apiClientMetric.
     */
    @java.lang.Override
    public art.ameliah.pulsewatcher.proto.APIClientMetric getApiClientMetric() {
      if (apiClientMetricBuilder_ == null) {
        if (metricsCase_ == 3) {
          return (art.ameliah.pulsewatcher.proto.APIClientMetric) metrics_;
        }
        return art.ameliah.pulsewatcher.proto.APIClientMetric.getDefaultInstance();
      } else {
        if (metricsCase_ == 3) {
          return apiClientMetricBuilder_.getMessage();
        }
        return art.ameliah.pulsewatcher.proto.APIClientMetric.getDefaultInstance();
      }
    }
    /**
     * <code>.art.ameliah.pulsewatcher.APIClientMetric apiClientMetric = 3;</code>
     */
    public Builder setApiClientMetric(art.ameliah.pulsewatcher.proto.APIClientMetric value) {
      if (apiClientMetricBuilder_ == null) {
        if (value == null) {
          throw new NullPointerException();
        }
        metrics_ = value;
        onChanged();
      } else {
        apiClientMetricBuilder_.setMessage(value);
      }
      metricsCase_ = 3;
      return this;
    }
    /**
     * <code>.art.ameliah.pulsewatcher.APIClientMetric apiClientMetric = 3;</code>
     */
    public Builder setApiClientMetric(
        art.ameliah.pulsewatcher.proto.APIClientMetric.Builder builderForValue) {
      if (apiClientMetricBuilder_ == null) {
        metrics_ = builderForValue.build();
        onChanged();
      } else {
        apiClientMetricBuilder_.setMessage(builderForValue.build());
      }
      metricsCase_ = 3;
      return this;
    }
    /**
     * <code>.art.ameliah.pulsewatcher.APIClientMetric apiClientMetric = 3;</code>
     */
    public Builder mergeApiClientMetric(art.ameliah.pulsewatcher.proto.APIClientMetric value) {
      if (apiClientMetricBuilder_ == null) {
        if (metricsCase_ == 3 &&
            metrics_ != art.ameliah.pulsewatcher.proto.APIClientMetric.getDefaultInstance()) {
          metrics_ = art.ameliah.pulsewatcher.proto.APIClientMetric.newBuilder((art.ameliah.pulsewatcher.proto.APIClientMetric) metrics_)
              .mergeFrom(value).buildPartial();
        } else {
          metrics_ = value;
        }
        onChanged();
      } else {
        if (metricsCase_ == 3) {
          apiClientMetricBuilder_.mergeFrom(value);
        } else {
          apiClientMetricBuilder_.setMessage(value);
        }
      }
      metricsCase_ = 3;
      return this;
    }
    /**
     * <code>.art.ameliah.pulsewatcher.APIClientMetric apiClientMetric = 3;</code>
     */
    public Builder clearApiClientMetric() {
      if (apiClientMetricBuilder_ == null) {
        if (metricsCase_ == 3) {
          metricsCase_ = 0;
          metrics_ = null;
          onChanged();
        }
      } else {
        if (metricsCase_ == 3) {
          metricsCase_ = 0;
          metrics_ = null;
        }
        apiClientMetricBuilder_.clear();
      }
      return this;
    }
    /**
     * <code>.art.ameliah.pulsewatcher.APIClientMetric apiClientMetric = 3;</code>
     */
    public art.ameliah.pulsewatcher.proto.APIClientMetric.Builder getApiClientMetricBuilder() {
      return getApiClientMetricFieldBuilder().getBuilder();
    }
    /**
     * <code>.art.ameliah.pulsewatcher.APIClientMetric apiClientMetric = 3;</code>
     */
    @java.lang.Override
    public art.ameliah.pulsewatcher.proto.APIClientMetricOrBuilder getApiClientMetricOrBuilder() {
      if ((metricsCase_ == 3) && (apiClientMetricBuilder_ != null)) {
        return apiClientMetricBuilder_.getMessageOrBuilder();
      } else {
        if (metricsCase_ == 3) {
          return (art.ameliah.pulsewatcher.proto.APIClientMetric) metrics_;
        }
        return art.ameliah.pulsewatcher.proto.APIClientMetric.getDefaultInstance();
      }
    }
    /**
     * <code>.art.ameliah.pulsewatcher.APIClientMetric apiClientMetric = 3;</code>
     */
    private com.google.protobuf.SingleFieldBuilderV3<
        art.ameliah.pulsewatcher.proto.APIClientMetric, art.ameliah.pulsewatcher.proto.APIClientMetric.Builder, art.ameliah.pulsewatcher.proto.APIClientMetricOrBuilder> 
        getApiClientMetricFieldBuilder() {
      if (apiClientMetricBuilder_ == null) {
        if (!(metricsCase_ == 3)) {
          metrics_ = art.ameliah.pulsewatcher.proto.APIClientMetric.getDefaultInstance();
        }
        apiClientMetricBuilder_ = new com.google.protobuf.SingleFieldBuilderV3<
            art.ameliah.pulsewatcher.proto.APIClientMetric, art.ameliah.pulsewatcher.proto.APIClientMetric.Builder, art.ameliah.pulsewatcher.proto.APIClientMetricOrBuilder>(
                (art.ameliah.pulsewatcher.proto.APIClientMetric) metrics_,
                getParentForChildren(),
                isClean());
        metrics_ = null;
      }
      metricsCase_ = 3;
      onChanged();
      return apiClientMetricBuilder_;
    }
    @java.lang.Override
    public final Builder setUnknownFields(
        final com.google.protobuf.UnknownFieldSet unknownFields) {
      return super.setUnknownFields(unknownFields);
    }

    @java.lang.Override
    public final Builder mergeUnknownFields(
        final com.google.protobuf.UnknownFieldSet unknownFields) {
      return super.mergeUnknownFields(unknownFields);
    }


    // @@protoc_insertion_point(builder_scope:art.ameliah.pulsewatcher.C2SMetricPacket)
  }

  // @@protoc_insertion_point(class_scope:art.ameliah.pulsewatcher.C2SMetricPacket)
  private static final art.ameliah.pulsewatcher.proto.C2SMetricPacket DEFAULT_INSTANCE;
  static {
    DEFAULT_INSTANCE = new art.ameliah.pulsewatcher.proto.C2SMetricPacket();
  }

  public static art.ameliah.pulsewatcher.proto.C2SMetricPacket getDefaultInstance() {
    return DEFAULT_INSTANCE;
  }

  private static final com.google.protobuf.Parser<C2SMetricPacket>
      PARSER = new com.google.protobuf.AbstractParser<C2SMetricPacket>() {
    @java.lang.Override
    public C2SMetricPacket parsePartialFrom(
        com.google.protobuf.CodedInputStream input,
        com.google.protobuf.ExtensionRegistryLite extensionRegistry)
        throws com.google.protobuf.InvalidProtocolBufferException {
      Builder builder = newBuilder();
      try {
        builder.mergeFrom(input, extensionRegistry);
      } catch (com.google.protobuf.InvalidProtocolBufferException e) {
        throw e.setUnfinishedMessage(builder.buildPartial());
      } catch (com.google.protobuf.UninitializedMessageException e) {
        throw e.asInvalidProtocolBufferException().setUnfinishedMessage(builder.buildPartial());
      } catch (java.io.IOException e) {
        throw new com.google.protobuf.InvalidProtocolBufferException(e)
            .setUnfinishedMessage(builder.buildPartial());
      }
      return builder.buildPartial();
    }
  };

  public static com.google.protobuf.Parser<C2SMetricPacket> parser() {
    return PARSER;
  }

  @java.lang.Override
  public com.google.protobuf.Parser<C2SMetricPacket> getParserForType() {
    return PARSER;
  }

  @java.lang.Override
  public art.ameliah.pulsewatcher.proto.C2SMetricPacket getDefaultInstanceForType() {
    return DEFAULT_INSTANCE;
  }

}
